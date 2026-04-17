<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\CustomerSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        // ─── Auth ───────────────────────────────────────────────────────────
        $apiKey = $request->query('api_key') ?? $request->header('X-Api-Key');

        if (! $apiKey) {
            return response()->json(['error' => 'API key wajib disertakan.'], 401);
        }

        $admin = User::where('role', 'admin')
            ->whereNotNull('api_key')
            ->where('api_key', $apiKey)
            ->first();

        if (! $admin) {
            return response()->json(['error' => 'API key tidak valid atau tidak memiliki akses.'], 403);
        }

        // ─── Parameter bulan / tahun ─────────────────────────────────────────
        $now = Carbon::now();
        $month = (int) ($request->query('month') ?: $now->month);
        $year = (int) ($request->query('year') ?: $now->year);

        if ($month < 1 || $month > 12) {
            return response()->json(['error' => 'Parameter month harus antara 1 dan 12.'], 422);
        }

        // ─── Generate ────────────────────────────────────────────────────────
        $generated = 0;
        $skipped = 0;
        $errors = [];

        CustomerSubscription::withoutGlobalScopes()
            ->whereRaw('is_active IS TRUE')
            ->with(['package' => fn ($q) => $q->withoutGlobalScopes(), 'customer'])
            ->chunkById(100, function ($subscriptions) use ($month, $year, &$generated, &$skipped, &$errors) {
                foreach ($subscriptions as $subscription) {
                    if (! $subscription->package || ! $subscription->customer) {
                        $skipped++;

                        continue;
                    }

                    // Idempotency: skip jika tagihan bulan ini sudah ada
                    $exists = Billing::withoutGlobalScopes()
                        ->where('subscription_id', $subscription->id)
                        ->where('billing_month', $month)
                        ->where('billing_year', $year)
                        ->exists();

                    if ($exists) {
                        $skipped++;

                        continue;
                    }

                    $lastBilling = Billing::withoutGlobalScopes()
                        ->where('subscription_id', $subscription->id)
                        ->orderByDesc('billing_year')
                        ->orderByDesc('billing_month')
                        ->first();

                    $dueDate = Carbon::parse($lastBilling->due_date)->addMonth();

                    try {
                        DB::transaction(function () use ($subscription, $month, $year, $dueDate) {
                            Billing::create([
                                'user_id' => $subscription->user_id,
                                'customer_id' => $subscription->customer_id,
                                'subscription_id' => $subscription->id,
                                'amount' => $subscription->package->price,
                                'status' => 'unpaid',
                                'due_date' => $dueDate->toDateString(),
                                'payment_date' => null,
                                'billing_month' => $month,
                                'billing_year' => $year,
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
            'oleh' => $admin->username,
            'bulan' => "{$month}/{$year}",
            'generated' => $generated,
            'skipped' => $skipped,
            'errors' => count($errors),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Generate billing {$month}/{$year} selesai.",
            'generated' => $generated,
            'skipped' => $skipped,
            'errors' => $errors,
        ]);
    }
}
