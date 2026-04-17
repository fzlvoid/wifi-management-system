<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\Customer;

class DashboardService
{
    /**
     * Calculate Total Active Customers.
     */
    public function getTotalActiveCustomers(): int
    {
        return Customer::whereRaw('is_active IS TRUE')->count();
    }

    /**
     * Calculate Total Revenue for the current month (status: paid).
     */
    public function getCurrentMonthRevenue(): int
    {
        return Billing::where('billing_year', now()->year)
            ->where('billing_month', now()->month)
            ->where('status', 'paid')
            ->sum('amount');
    }

    /**
     * Calculate Total Receivables (status: unpaid + overdue).
     */
    public function getTotalReceivables(): int
    {
        return Billing::whereIn('status', ['unpaid', 'overdue'])
            ->sum('amount');
    }

    /**
     * Get count of Unpaid Bills.
     */
    public function getUnpaidBillsCount(): int
    {
        return Billing::whereIn('status', ['unpaid', 'overdue'])->count();
    }

    /**
     * Get all active customers with latest billing status and active subscription.
     */
    public function getCustomerList(?string $search = null, ?string $statusFilter = null)
    {
        $query = Customer::whereRaw('is_active IS TRUE')
            ->with([
                'subscriptions' => fn ($q) => $q->whereRaw('is_active IS TRUE')->with('package'),
                'billings' => fn ($q) => $q
                    ->where('billing_month', now()->month)
                    ->where('billing_year', now()->year)
                    ->orderBy('due_date', 'asc'),
            ]);

        if (! empty($search)) {
            $query->where('name', 'ilike', '%'.$search.'%');
        }

        if (! empty($statusFilter)) {
            $now = now()->startOfDay();
            if ($statusFilter === 'active') {
                $query->whereHas('subscriptions', function ($q) use ($now) {
                    $q->whereRaw('is_active IS TRUE')
                        ->where('end_date', '>', $now->copy()->addDays(7));
                });
            } elseif ($statusFilter === 'due_soon') {
                $query->whereHas('subscriptions', function ($q) use ($now) {
                    $q->whereRaw('is_active IS TRUE')
                        ->where('end_date', '<=', $now->copy()->addDays(7))
                        ->where('end_date', '>=', $now);
                });
            } elseif ($statusFilter === 'overdue') {
                $query->whereHas('subscriptions', function ($q) use ($now) {
                    $q->whereRaw('is_active IS TRUE')
                        ->where('end_date', '<', $now);
                });
            }
        }

        return $query->orderBy('name')->paginate(10);
    }

    /**
     * List Top 5 Recent Payments.
     */
    public function getRecentPayments(int $limit = 5)
    {
        return Billing::with(['customer', 'subscription.package'])
            ->where('status', 'paid')
            ->whereNotNull('payment_date')
            ->orderBy('payment_date', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * List Top 5 Customers with Overdue Bills.
     */
    public function getOverdueCustomers(int $limit = 5)
    {
        return Customer::whereRaw('is_active IS TRUE')
            ->whereHas('subscriptions', fn ($q) => $q->whereRaw('is_active IS TRUE')->where('end_date', '<', now()->startOfDay()))
            ->whereHas('billings', fn ($q) => $q->whereIn('status', ['unpaid', 'overdue']))
            ->with([
                'billings' => fn ($q) => $q->whereIn('status', ['unpaid', 'overdue'])->orderBy('due_date', 'asc'),
                'subscriptions' => fn ($q) => $q->whereRaw('is_active IS TRUE')->with('package'),
            ])
            ->get()
            ->sortBy(fn ($customer) => $customer->subscriptions->first()->end_date)
            ->take($limit);
    }

    /**
     * Provide data for a Monthly Revenue Growth chart (last 12 months).
     */
    public function getMonthlyRevenueGrowth(int $months = 12): array
    {
        $startDate = now()->subMonths($months - 1)->startOfMonth();

        $revenueData = Billing::selectRaw('billing_year, billing_month, SUM(amount) as total')
            ->where('status', 'paid')
            ->where('payment_date', '>=', $startDate)
            ->groupBy('billing_year', 'billing_month')
            ->orderBy('billing_year')
            ->orderBy('billing_month')
            ->get();

        // Format data for chart
        $labels = [];
        $data = [];

        // Fill in missing months with 0
        for ($i = 0; $i < $months; $i++) {
            $date = clone $startDate;
            $date->addMonths($i);

            $year = $date->year;
            $month = $date->month;

            $monthLabel = $date->locale('id')->translatedFormat('M Y');
            $labels[] = $monthLabel;

            $record = $revenueData->first(fn ($item) => $item->billing_year == $year && $item->billing_month == $month);
            $data[] = $record ? (int) $record->total : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
