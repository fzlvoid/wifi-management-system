<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private PaymentService $paymentService,
    ) {}

    public function index(Request $request): View
    {
        $summary = [
            'totalActiveCustomers' => $this->dashboardService->getTotalActiveCustomers(),
            'currentMonthRevenue' => $this->dashboardService->getCurrentMonthRevenue(),
            'totalReceivables' => $this->dashboardService->getTotalReceivables(),
            'unpaidBillsCount' => $this->dashboardService->getUnpaidBillsCount(),
        ];

        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $customerList = $this->dashboardService->getCustomerList($search, $statusFilter);
        $overdueCustomers = $this->dashboardService->getOverdueCustomers(5);
        $chartData = $this->dashboardService->getMonthlyRevenueGrowth(12);

        return view('dashboard.index', compact('summary', 'customerList', 'overdueCustomers', 'chartData'));
    }

    public function markAsPaid(int $id): RedirectResponse
    {
        $result = $this->paymentService->confirmPayment($id);

        $key = $result['success'] ? 'success' : 'error';

        return redirect()->back()->with($key, $result['message']);
    }

    public function reversal(int $id): RedirectResponse
    {
        $result = $this->paymentService->cancelPayment($id);

        $key = $result['success'] ? 'success' : 'error';

        return redirect()->back()->with($key, $result['message']);
    }
}
