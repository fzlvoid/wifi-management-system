<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;


class DashboardController extends Controller
{
    private function allUsers(): \Illuminate\Support\Collection
    {
        return collect([
            ['id' => 1,  'name' => 'Sarah Johnson',  'unit' => 'Unit A101', 'package' => 'FastNet 50Mbps', 'last_paid' => '2023-10-01', 'due_date' => '2023-11-01', 'status' => 'PAID',   'subscription' => 'ACTIVE'],
            ['id' => 2,  'name' => 'Mike Chen',      'unit' => 'Unit B202', 'package' => 'Pro 100Mbps',    'last_paid' => '2023-09-28', 'due_date' => '2023-10-28', 'status' => 'PAID',   'subscription' => 'ACTIVE'],
            ['id' => 3,  'name' => 'Alex Smith',     'unit' => 'Unit C303', 'package' => '50Mbps',         'last_paid' => '2023-10-15', 'due_date' => '2023-11-15', 'status' => 'PAID',   'subscription' => 'ACTIVE'],
            ['id' => 4,  'name' => 'Priya Patel',    'unit' => 'Unit D404', 'package' => '100Mbps',        'last_paid' => '2023-10-10', 'due_date' => '2023-11-10', 'status' => 'PAID',   'subscription' => 'ACTIVE'],
            ['id' => 5,  'name' => 'Tom Williams',   'unit' => 'Unit E505', 'package' => '50Mbps',         'last_paid' => '2023-10-18', 'due_date' => '2023-11-18', 'status' => 'UNPAID', 'subscription' => 'ACTIVE'],
            ['id' => 6,  'name' => 'Ben Lee',        'unit' => 'Unit F606', 'package' => '100Mbps',        'last_paid' => '2023-10-05', 'due_date' => '2023-11-05', 'status' => 'UNPAID', 'subscription' => 'ACTIVE'],
            ['id' => 7,  'name' => 'Lisa Kim',       'unit' => 'Unit G707', 'package' => 'FastNet 50Mbps', 'last_paid' => '2023-10-12', 'due_date' => '2023-11-12', 'status' => 'PAID',   'subscription' => 'ACTIVE'],
            ['id' => 8,  'name' => 'David Park',     'unit' => 'Unit H808', 'package' => 'Pro 100Mbps',    'last_paid' => '2023-10-20', 'due_date' => '2023-11-20', 'status' => 'PAID',   'subscription' => 'ACTIVE'],
            ['id' => 9,  'name' => 'Emma Wilson',    'unit' => 'Unit I909', 'package' => '50Mbps',         'last_paid' => '2023-09-01', 'due_date' => '2023-10-01', 'status' => 'UNPAID', 'subscription' => 'INACTIVE'],
            ['id' => 10, 'name' => 'James Brown',    'unit' => 'Unit J010', 'package' => '100Mbps',        'last_paid' => '2023-08-15', 'due_date' => '2023-09-15', 'status' => 'UNPAID', 'subscription' => 'INACTIVE'],
        ]);
    }

    public function index(Request $request)
    {
        $adminId = auth()->id();
        $search  = trim($request->input('search', ''));
        $status  = $request->input('status', 'all');

        $query = Customer::with(['package:id,package_name'])
            ->where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE');
        
        if ($search !== '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status !== 'all') {
            $query->whereHas('latestPayment', function($q) use ($status) {
                $q->where('status', strtoupper($status));
            });
        }

        $users = $query->paginate(5);

        $currentMonth = now()->month;
        $currentYear  = now()->year;

        $activeCustomersCount = Customer::where('user_id', $adminId)
            ->whereRaw('is_active IS TRUE')
            ->count();

        $totalRevenue = Payment::whereHas('customer', fn($q) => $q->where('user_id', $adminId))
            ->where('status', 'PAID')
            ->whereYear('payment_date', $currentYear)
            ->whereMonth('payment_date', $currentMonth)
            ->sum('amount_paid');

        $summary = [
            'total'   => $activeCustomersCount,
            'paid'    => Payment::whereHas('customer', fn($q) => $q->where('user_id', $adminId))
                        ->where('status', 'PAID')
                        ->whereYear('payment_date', $currentYear)
                        ->whereMonth('payment_date', $currentMonth)
                        ->count(),
            'unpaid'  => Payment::whereHas('customer', fn($q) => $q->where('user_id', $adminId))
                        ->where('status', 'UNPAID')
                        ->count(),
            'revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
        ];

        $overdueUsers = Customer::with(['latestPayment'])
            ->where('user_id', $adminId)
            ->whereHas('latestPayment', fn($q) => $q->where('status', 'UNPAID'))
            ->get();

        return view('dashboard.index', compact('users', 'summary', 'overdueUsers'));

        
        // $deactivated = session('deactivated_users', []);
        // $paidUsers   = session('paid_users', []);

        // $all = $this->allUsers()->map(function ($user) use ($deactivated, $paidUsers) {
        //     if (in_array($user['id'], $deactivated)) {
        //         $user['subscription'] = 'INACTIVE';
        //     }
        //     if (isset($paidUsers[$user['id']])) {
        //         $user['status']    = 'PAID';
        //         $user['last_paid'] = $paidUsers[$user['id']];
        //     }
        //     return $user;
        // });

        // $search  = trim($request->input('search', ''));
        // $status  = $request->input('status', 'all');
        // $perPage = 5;
        // $page    = (int) $request->input('page', 1);

        // $filtered = $all
        //     ->where('subscription', 'ACTIVE')
        //     ->when($search !== '', fn($c) => $c->filter(
        //         fn($u) => str_contains(strtolower($u['name']), strtolower($search))
        //     ))
        //     ->when($status !== 'all', fn($c) => $c->filter(
        //         fn($u) => strtolower($u['status']) === strtolower($status)
        //     ))
        //     ->values();

        // $users = new LengthAwarePaginator(
        //     $filtered->forPage($page, $perPage),
        //     $filtered->count(),
        //     $perPage,
        //     $page,
        //     ['path' => $request->url(), 'query' => $request->except('page')]
        // );

        // $activeUsers = $all->where('subscription', 'ACTIVE');

        // $summary = [
        //     'total'   => $activeUsers->count(),
        //     'paid'    => $activeUsers->where('status', 'PAID')->count(),
        //     'unpaid'  => $activeUsers->where('status', 'UNPAID')->count(),
        //     'revenue' => 'Rp ' . number_format($activeUsers->where('status', 'PAID')->count() * 300000, 0, ',', '.'),
        // ];

        // $overdueUsers = $all->where('status', 'UNPAID')->values();

        // return view('dashboard.index', compact('users', 'summary', 'overdueUsers'));
    }

    public function markAsPaid(Request $request, int $id)
    {
        $request->validate(['paid_date' => ['required', 'date']]);

        $paidUsers       = session('paid_users', []);
        $paidUsers[$id]  = $request->input('paid_date');
        session(['paid_users' => $paidUsers]);

        return redirect()->back()
            ->with('success', 'Payment recorded successfully.');
    }
}
