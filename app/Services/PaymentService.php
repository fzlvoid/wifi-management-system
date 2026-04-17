<?php

namespace App\Services;

use App\Events\PaymentReceived;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Konfirmasi pembayaran tagihan.
     *
     * @return array{success: bool, message: string, billing: Billing, remaining_unpaid: int}
     *
     * @throws ModelNotFoundException
     * @throws \RuntimeException
     */
    public function confirmPayment(int $billingId): array
    {
        /** @var Billing $billing */
        $billing = Billing::with('customer')->findOrFail($billingId);

        if ($billing->status === 'paid') {
            return [
                'success' => false,
                'message' => 'Tagihan ini sudah berstatus lunas.',
                'billing' => $billing,
                'remaining_unpaid' => 0,
            ];
        }

        $wasOverdue = $billing->status === 'unpaid' && Carbon::parse($billing->due_date)->endOfDay()->isPast();

        DB::transaction(function () use ($billing, &$remainingUnpaid) {
            $billing->update([
                'status' => 'paid',
                'payment_date' => now(),
            ]);

            $billing->refresh();

            // Update end_date di subscription jika billing due_date lebih baru
            if ($billing->subscription) {
                $newEndDate = $billing->due_date;
                $currentEndDate = $billing->subscription->end_date;

                if (! $currentEndDate || $newEndDate->gt($currentEndDate)) {
                    $billing->subscription->update([
                        'end_date' => $newEndDate->toDateString(),
                    ]);
                }
            }

            // Jika membayar tagihan overdue, cek apakah ada tunggakan lain
            $remainingUnpaid = Billing::where('customer_id', $billing->customer_id)
                ->where('status', 'unpaid')
                ->where('id', '!=', $billing->id)
                ->get();

            // Dispatch event setelah commit — listener bisa handle WA & Mikrotik
            event(new PaymentReceived(
                billing: $billing,
                customer: $billing->customer,
                remainingUnpaidBillings: $remainingUnpaid,
            ));
        });

        $remainingCount = isset($remainingUnpaid) ? $remainingUnpaid->count() : 0;

        Log::info('PaymentService: pembayaran dikonfirmasi', [
            'billing_id' => $billing->id,
            'customer' => $billing->customer->name,
            'was_overdue' => $wasOverdue,
            'remaining_unpaid' => $remainingCount,
        ]);

        $message = $wasOverdue && $remainingCount > 0
            ? "Pembayaran berhasil. Masih ada {$remainingCount} tunggakan lain yang belum lunas."
            : 'Pembayaran berhasil dikonfirmasi.';

        return [
            'success' => true,
            'message' => $message,
            'billing' => $billing,
            'remaining_unpaid' => $remainingCount,
        ];
    }

    /**
     * Batal konfirmasi pembayaran (kembalikan ke unpaid/overdue).
     *
     * @return array{success: bool, message: string, billing: Billing}
     *
     * @throws ModelNotFoundException
     * @throws \RuntimeException
     */
    public function cancelPayment(int $billingId): array
    {
        /** @var Billing $billing */
        $billing = Billing::with('customer', 'subscription')->findOrFail($billingId);

        if ($billing->status !== 'paid') {
            return [
                'success' => false,
                'message' => 'Tagihan ini belum lunas, tidak bisa dibatalkan.',
                'billing' => $billing,
            ];
        }

        DB::transaction(function () use ($billing) {
            $newStatus = 'unpaid';

            $billing->update([
                'status' => $newStatus,
                'payment_date' => null,
            ]);

            // Kembalikan end_date di subscription
            if ($billing->subscription) {
                // Cari billing berstatus paid terakhir yang tersisa
                $lastPaidBilling = Billing::where('subscription_id', $billing->subscription_id)
                    ->where('status', 'paid')
                    ->orderByDesc('due_date')
                    ->first();

                if ($lastPaidBilling) {
                    $newEndDate = $lastPaidBilling->due_date;
                } else {
                    // Jika tidak ada yang paid sama sekali, kembalikan ke start_date + 1 bulan
                    $newEndDate = Carbon::parse($billing->subscription->start_date)->addMonth()->toDateString();
                }

                $billing->subscription->update([
                    'end_date' => $newEndDate,
                ]);
            }
        });

        Log::info('PaymentService: pembayaran dibatalkan', [
            'billing_id' => $billing->id,
            'customer' => $billing->customer->name,
        ]);

        return [
            'success' => true,
            'message' => 'Pembayaran berhasil dibatalkan.',
            'billing' => $billing,
        ];
    }
}
