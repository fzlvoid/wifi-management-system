<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    private array $cache = [];

    private function remember(string $key, callable $callback): mixed
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }

        return $this->cache[$key] = $callback();
    }

    /**
     * All 4 summary metrics in one call.
     *
     * 2 DB queries total (not 4):
     *   1. Customer::count          — total active customers
     *   2. Billing conditional agg  — current month revenue + receivables + unpaid count
     *
     * Cached for 60s under a single key per user (fewer cache reads too).
     */
    public function getDashboardSummary(): array
    {
        return $this->remember(__METHOD__, fn () => Cache::remember(
            'dashboard:summary:'.auth()->id(),
            60,
            function () {
                $billingStats = Billing::selectRaw("
                    COALESCE(SUM(CASE WHEN billing_year = ? AND billing_month = ? AND status = 'paid' THEN amount ELSE 0 END), 0) as current_month_revenue,
                    COALESCE(SUM(CASE WHEN status = 'unpaid' THEN amount ELSE 0 END), 0) as total_receivables,
                    SUM(CASE WHEN status = 'unpaid' THEN 1 ELSE 0 END) as unpaid_bills_count
                ", [now()->year, now()->month])->first();

                return [
                    'totalActiveCustomers' => Customer::query()->where('is_active', true)->count(),
                    'currentMonthRevenue' => (int) $billingStats->current_month_revenue,
                    'totalReceivables' => (int) $billingStats->total_receivables,
                    'unpaidBillsCount' => (int) $billingStats->unpaid_bills_count,
                ];
            }
        ));
    }

    public function getCustomerList(?string $search = null, ?string $statusFilter = null)
    {
        return $this->remember(__METHOD__.':'.$search.':'.$statusFilter, function () use ($search, $statusFilter) {
            $query = Customer::query()
                ->where('is_active', true)
                ->with([
                    'subscriptions' => fn ($q) => $q->where('is_active', true)->with('package'),
                    'billings' => fn ($q) => $q->orderBy('due_date', 'desc'),
                ]);

            if (! empty($search)) {
                $query->where('name', 'like', '%'.$search.'%');
            }

            if (! empty($statusFilter)) {
                $now = now()->startOfDay();
                if ($statusFilter === 'active') {
                    $query->whereHas('subscriptions', function ($q) use ($now) {
                        $q->where('is_active', true)
                            ->where('end_date', '>', $now->copy()->addDays(7));
                    });
                } elseif ($statusFilter === 'due_soon') {
                    $query->whereHas('subscriptions', function ($q) use ($now) {
                        $q->where('is_active', true)
                            ->where('end_date', '<=', $now->copy()->addDays(7))
                            ->where('end_date', '>=', $now);
                    });
                } elseif ($statusFilter === 'overdue') {
                    $query->whereHas('subscriptions', function ($q) use ($now) {
                        $q->where('is_active', true)
                            ->where('end_date', '<', $now);
                    });
                }
            }

            return $query->orderBy('name')->paginate(10);
        });
    }

    public function getOverdueCustomers(int $limit = 5)
    {
        return $this->remember(__METHOD__.':'.$limit, fn () => Customer::where('is_active', true)
            ->whereHas('subscriptions', fn ($q) => $q->where('is_active', true)->where('end_date', '<', now()->startOfDay()))
            ->whereHas('billings', fn ($q) => $q->where('status', 'unpaid'))
            ->with([
                'billings' => fn ($q) => $q->where('status', 'unpaid')->orderBy('due_date', 'asc'),
                'subscriptions' => fn ($q) => $q->where('is_active', true)->with('package'),
            ])
            ->get()
            ->sortBy(fn ($customer) => $customer->subscriptions->first()->end_date)
            ->take($limit));
    }

    public function getMonthlyRevenueGrowth(int $months = 12): array
    {
        return $this->remember(__METHOD__.':'.$months, fn () => Cache::remember(
            'dashboard:monthly_revenue_growth:'.auth()->id(),
            60,
            function () use ($months) {
                $startDate = now()->subMonths($months - 1)->startOfMonth();

                $revenueData = Billing::selectRaw('billing_year, billing_month, SUM(amount) as total')
                    ->where('status', 'paid')
                    ->where('payment_date', '>=', $startDate)
                    ->groupBy('billing_year', 'billing_month')
                    ->orderBy('billing_year')
                    ->orderBy('billing_month')
                    ->get();

                $labels = [];
                $data = [];

                for ($i = 0; $i < $months; $i++) {
                    $date = clone $startDate;
                    $date->addMonths($i);

                    $year = $date->year;
                    $month = $date->month;

                    $labels[] = $date->locale('id')->translatedFormat('M Y');
                    $record = $revenueData->first(fn ($item) => $item->billing_year == $year && $item->billing_month == $month);
                    $data[] = $record ? (int) $record->total : 0;
                }

                return [
                    'labels' => $labels,
                    'data' => $data,
                ];
            }
        ));
    }

    /**
     * Flush dashboard summary cache.
     * Call after payment confirmation, reversal, or any mutation that changes metrics.
     */
    public function flushSummaryCache(): void
    {
        $userId = auth()->id();
        Cache::forget('dashboard:summary:'.$userId);
        Cache::forget('dashboard:monthly_revenue_growth:'.$userId);
    }
}
