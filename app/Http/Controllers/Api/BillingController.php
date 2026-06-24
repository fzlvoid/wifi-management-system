<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\CustomerSubscription;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $now = Carbon::now()->startOfDay();
        $cutoffDate = $now->copy()->addDays(7);

        $generated = 0;
        $skipped = 0;
        $errors = [];

        CustomerSubscription::withoutGlobalScopes()
            ->where('is_active', true)
            ->where('end_date', '<=', $cutoffDate->toDateString())
            ->with(['package' => fn ($q) => $q->withoutGlobalScopes(), 'customer'])
            ->chunkById(100, function ($subscriptions) use ($now, &$generated, &$skipped, &$errors) {
                foreach ($subscriptions as $subscription) {
                    if (! $subscription->package || ! $subscription->customer) {
                        $skipped++;
                        Log::warning('BillingController@generate: skip subscription tanpa package/customer', [
                            'subscription_id' => $subscription->id,
                        ]);

                        continue;
                    }

                    $endDate = Carbon::parse($subscription->end_date)->startOfDay();

                    if ($endDate->gt($now->copy()->addDays(7))) {
                        $skipped++;

                        continue;
                    }

                    $latestBilling = Billing::withoutGlobalScopes()
                        ->where('subscription_id', $subscription->id)
                        ->orderByDesc('due_date')
                        ->first();

                    if (! $latestBilling || $latestBilling->status !== 'paid') {
                        $skipped++;

                        continue;
                    }

                    $billingMonth = $endDate->month;
                    $billingYear = $endDate->year;

                    $alreadyExists = Billing::withoutGlobalScopes()
                        ->where('subscription_id', $subscription->id)
                        ->where('billing_month', $billingMonth)
                        ->where('billing_year', $billingYear)
                        ->exists();

                    if ($alreadyExists) {
                        $skipped++;

                        continue;
                    }

                    $dueDate = $endDate->copy()->addMonth();

                    try {
                        DB::transaction(function () use ($subscription, $billingMonth, $billingYear, $dueDate) {
                            Billing::create([
                                'user_id' => $subscription->user_id,
                                'customer_id' => $subscription->customer_id,
                                'subscription_id' => $subscription->id,
                                'amount' => $subscription->package->price,
                                'status' => 'unpaid',
                                'due_date' => $dueDate->toDateString(),
                                'payment_date' => null,
                                'billing_month' => $billingMonth,
                                'billing_year' => $billingYear,
                            ]);
                        });

                        $generated++;
                    } catch (\Throwable $e) {
                        $errors[] = [
                            'subscription_id' => $subscription->id,
                            'customer' => $subscription->customer->name,
                            'error' => $e->getMessage(),
                        ];

                        Log::error('BillingController@generate: gagal buat billing', [
                            'subscription_id' => $subscription->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        Log::info('API billing:generate selesai', [
            'oleh' => $request->attributes->get('api_user')->username,
            'generated' => $generated,
            'skipped' => $skipped,
            'errors' => count($errors),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Generate billing selesai.',
            'generated' => $generated,
            'skipped' => $skipped,
            'errors' => $errors,
        ]);
    }
}
