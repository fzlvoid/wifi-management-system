<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', 'all');

        $query = Customer::with(['package', 'latestPayment'])
            ->whereRaw('is_active IS TRUE');

        if ($search !== '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status !== 'all') {
            if ($status === 'paid') {
                $query->whereHas('latestPayment', fn($q) => $q->where('status', 'PAID'));
            } elseif ($status === 'unpaid') {
                $query->whereHas('latestPayment', fn($q) => $q->where('status', 'UNPAID')
                    ->where('due_date', '>=', now()->toDateString()));
            } elseif ($status === 'overdue') {
                $query->whereHas('latestPayment', fn($q) => $q->where('status', 'UNPAID')
                    ->where('due_date', '<', now()->toDateString()));
            }
        }

        $customers = $query->paginate(10);

        // Summary cards
        $allActive = Customer::whereRaw('is_active IS TRUE');

        $currentBillingMonth = now()->format('Y-m');

        $activeCustomersCount = (clone $allActive)->count();

        $paidCount = Payment::whereIn(
            'customer_id',
            (clone $allActive)->pluck('id')
        )
            ->where('billing_month', $currentBillingMonth)
            ->where('status', 'PAID')
            ->count();

        $unpaidCount = Customer::whereRaw('is_active IS TRUE')
            ->whereHas('latestPayment', fn($q) => $q->where('status', 'UNPAID'))
            ->count();

        $totalRevenue = Payment::whereIn(
            'customer_id',
            (clone $allActive)->pluck('id')
        )
            ->where('billing_month', $currentBillingMonth)
            ->where('status', 'PAID')
            ->sum('amount');

        $summary = [
            'total' => $activeCustomersCount,
            'paid' => $paidCount,
            'unpaid' => $unpaidCount,
            'revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
        ];

        // Overdue widget
        $overdueCustomers = Customer::with(['package', 'latestPayment'])
            ->whereRaw('is_active IS TRUE')
            ->whereHas('latestPayment', fn($q) => $q
                ->where('status', 'UNPAID')
                ->where('due_date', '<', now()->toDateString()))
            ->get();

        return view('dashboard.index', compact('customers', 'summary', 'overdueCustomers'));
    }

    public function markAsPaid(Request $request, int $id): RedirectResponse
    {
        $customer = Customer::with('latestPayment')->findOrFail($id);

        $payment = $customer->latestPayment;

        if (!$payment || $payment->status === 'PAID') {
            return redirect()->back()->with('error', 'Tagihan tidak ditemukan atau sudah PAID.');
        }

        $currentDueDate = Carbon::parse($payment->due_date)->startOfDay();
        $nextMonthBase = $currentDueDate->copy()->addMonth()->startOfMonth();
        $cycleDay = (int) ($customer->billing_cycle_date ?: $currentDueDate->day);
        $nextResolvedDay = min(max($cycleDay, 1), $nextMonthBase->daysInMonth);
        $nextDueDate = $nextMonthBase->copy()->day($nextResolvedDay);

        $payment->update([
            'status' => 'PAID',
            'payment_date' => now()->toDateString(),
            'due_date' => $nextDueDate->toDateString(),
            'billing_month' => $nextDueDate->format('Y-m'),
        ]);

        return redirect()->back()
            ->with('success', "Pembayaran {$customer->name} berhasil dicatat.");
    }

    public function reversal(int $id): RedirectResponse
    {
        $customer = Customer::with('latestPayment')->findOrFail($id);

        $payment = $customer->latestPayment;

        if (!$payment || $payment->status === 'UNPAID') {
            return redirect()->back()->with('error', 'Tagihan tidak ditemukan atau sudah UNPAID.');
        }

        $currentDueDate = Carbon::parse($payment->due_date)->startOfDay();
        $previousMonthBase = $currentDueDate->copy()->subMonth()->startOfMonth();
        $cycleDay = (int) ($customer->billing_cycle_date ?: $currentDueDate->day);
        $previousResolvedDay = min(max($cycleDay, 1), $previousMonthBase->daysInMonth);
        $previousDueDate = $previousMonthBase->copy()->day($previousResolvedDay);

        $payment->update([
            'status' => 'UNPAID',
            'payment_date' => null,
            'due_date' => $previousDueDate->toDateString(),
            'billing_month' => $previousDueDate->format('Y-m'),
        ]);

        return redirect()->back()
            ->with('success', "Pembayaran {$customer->name} berhasil di-reversal menjadi UNPAID.");
    }
}
