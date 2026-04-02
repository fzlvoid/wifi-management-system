<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BillingController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $apiKey = $request->query('api_key') ?? $request->header('X-Api-Key');

        if (! $apiKey) {
            return response()->json(['error' => 'API key diperlukan.'], 401);
        }

        // Cari user berdasarkan api_key
        $user = User::where('role', 'user')
            ->whereNotNull('api_key')
            ->get()
            ->first(fn (User $u) => Hash::check($apiKey, $u->api_key) || $u->api_key === $apiKey);

        if (! $user) {
            return response()->json(['error' => 'API key tidak valid.'], 401);
        }

        if (! $user->isSubscriptionActive()) {
            return response()->json(['error' => 'Langganan user telah berakhir.'], 403);
        }

        $today = Carbon::today();
        $targetDate = $today->copy()->addDays(5);

        // Tangani edge case tanggal 1-5: pakai bulan berjalan
        $billingMonth = $targetDate->format('Y-m');

        // Query pelanggan aktif dengan billing_cycle_date = hari ini + 5
        $customers = Customer::withoutGlobalScopes()
            ->with(['package' => fn ($q) => $q->withoutGlobalScopes()])
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->where('billing_cycle_date', $targetDate->day)
            ->get();

        $generated = 0;
        $skipped = 0;

        foreach ($customers as $customer) {
            // Cek apakah tagihan bulan ini sudah ada
            $exists = Payment::where('customer_id', $customer->id)
                ->where('billing_month', $billingMonth)
                ->exists();

            if ($exists) {
                $skipped++;

                continue;
            }

            // Snapshot harga saat ini
            $amount = $customer->package?->price ?? 0;

            // Due date = billing_cycle_date bulan target
            $dueDate = Carbon::create($targetDate->year, $targetDate->month, $customer->billing_cycle_date);

            Payment::create([
                'customer_id' => $customer->id,
                'amount' => $amount,
                'status' => 'UNPAID',
                'due_date' => $dueDate->toDateString(),
                'payment_date' => null,
                'billing_month' => $billingMonth,
            ]);

            $generated++;
        }

        return response()->json([
            'success' => true,
            'message' => 'Billing generation selesai.',
            'generated' => $generated,
            'skipped' => $skipped,
            'date' => $today->toDateString(),
            'target_billing_day' => $targetDate->day,
            'billing_month' => $billingMonth,
        ]);
    }
}
