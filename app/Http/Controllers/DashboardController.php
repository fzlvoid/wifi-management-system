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
        $summary = $this->dashboardService->getDashboardSummary();

        $customerList = $this->dashboardService->getCustomerList(
            $request->input('search'),
            $request->input('status')
        );

        return view('dashboard.index', [
            'summary' => $summary,
            'customerList' => $customerList,
            'overdueCustomers' => $this->dashboardService->getOverdueCustomers(5),
            'chartData' => $this->dashboardService->getMonthlyRevenueGrowth(12),
        ]);
    }

    public function markAsPaid(int $id): RedirectResponse
    {
        $result = $this->paymentService->confirmPayment($id);

        if ($result['success']) {
            $this->dashboardService->flushSummaryCache();
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function reversal(int $id): RedirectResponse
    {
        $result = $this->paymentService->cancelPayment($id);

        if ($result['success']) {
            $this->dashboardService->flushSummaryCache();
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
