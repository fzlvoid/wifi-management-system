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

        if (!$apiKey) {
            return response()->json(['error' => 'API key diperlukan.'], 401);
        }

        // Auth check: hanya Admin yang bisa meremot ini
        $admin = User::where('role', 'admin')
            ->whereNotNull('api_key')
            ->get()
            ->first(function (User $u) use ($apiKey) {
                if ($u->api_key === $apiKey) {
                    return true;
                }
                try {
                    return Hash::check($apiKey, $u->api_key);
                } catch (\Exception $e) {
                    return false;
                }
            });

        if (!$admin) {
            return response()->json(['error' => 'API key Admin tidak valid atau tidak memiliki akses.'], 403);
        }

        $today = Carbon::today();
        // Generate billing 5 hari sebelum jatuh tempo
        $targetDate = $today->copy()->addDays(5);
        $billingMonth = $targetDate->format('Y-m');

        // Query seluruh pelanggan aktif dari semua user
        $customers = Customer::withoutGlobalScopes()
            ->with(['package' => fn($q) => $q->withoutGlobalScopes(), 'user'])
            ->whereRaw('is_active IS TRUE')
            ->where('billing_cycle_date', $targetDate->day)
            ->get();

        $generated = 0;
        $skipped = 0;

        foreach ($customers as $customer) {
            // Lewati jika Pemilik (Internet Service Provider) pelanggan ini langganannya sudah mati
            if (!$customer->user || !$customer->user->isSubscriptionActive()) {
                continue;
            }

            // Cek apakah tagihan bulan ini sudah ada
            $exists = Payment::where('customer_id', $customer->id)
                ->where('billing_month', $billingMonth)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            // Snapshot harga saat ini dari relasi paket yang di-load tanpa scope
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
            'message' => 'Generate billing global selesai.',
            'generated' => $generated,
            'skipped' => $skipped,
            'date' => $today->toDateString(),
            'target_billing_day' => $targetDate->day,
            'billing_month' => $billingMonth,
        ]);
    }
}
