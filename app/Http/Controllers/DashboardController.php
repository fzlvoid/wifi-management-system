<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->user()->id;
        $search  = trim($request->input('search', ''));
        $status  = $request->input('status', 'all');

        $query = Customer::with(['package:id,package_name'])
            ->where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE');
        
        if ($search !== '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status !== 'all') {
            if ($status === 'paid') {
                $query->whereRaw('is_paid IS TRUE');
            } elseif ($status === 'unpaid') {
                $query->whereRaw('is_paid IS FALSE');
            }
        }

        $users = $query->paginate(5);

        $currentMonth = now()->month;
        $currentYear  = now()->year;

        $activeCustomersCount = Customer::where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE')
            ->count();

        $paidCustomers = Customer::where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE')
            ->whereRaw('is_paid IS TRUE')
            ->count();

        $unpaidCustomers = Customer::where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE')
            ->whereRaw('is_paid IS FALSE')
            ->count();

        $totalRevenue = Customer::join('packages', 'customers.package_id', '=', 'packages.id')
            ->where('customers.user_id', $adminId)
            ->whereRaw('customers.is_paid IS TRUE')
            ->sum('packages.price');

        $summary = [
            'total'   => $activeCustomersCount,
            'paid'    => $paidCustomers,
            'unpaid'  => $unpaidCustomers,
            'revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
        ];

        $overdueUsers = Customer::where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE')
            ->whereRaw('is_paid IS FALSE')
            ->whereDate('due_date', '<', now())
            ->get();

        return view('dashboard.index', compact('users', 'summary', 'overdueUsers'));
    }

    public function markAsPaid(Request $request, int $id)
    {
        $request->validate(['paid_date' => ['required', 'date']]);
        $adminId = $request->user()->id;

        $customer = Customer::where('id', $id)
                        ->where('user_id', $adminId)
                        ->firstOrFail();

        $billingDay = \Carbon\Carbon::parse($customer->due_date)->day;
        $newDueDate = now()->startOfMonth()->addMonth()->setDay($billingDay);

        $customer->update([
            'is_paid'   => DB::raw('TRUE'),
            'last_paid' => $request->input('paid_date'),
            'due_date'  => $newDueDate,
        ]);

        return redirect()->back()
            ->with('success', "Payment for {$customer->name} recorded successfully.");
    }
}
