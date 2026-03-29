<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    private const PACKAGES = [
        'FastNet 50Mbps' => 300000,
        'Pro 100Mbps'    => 500000,
    ];

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

    public function deactivated()
    {
        $deactivated = session('deactivated_users', []);

        $users = $this->allUsers()
            ->map(function ($user) use ($deactivated) {
                if (in_array($user['id'], $deactivated)) {
                    $user['subscription'] = 'INACTIVE';
                }
                return $user;
            })
            ->values();

        return view('users.deactivated', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['packages' => self::PACKAGES]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:100'],
            'unit'              => ['required', 'string', 'max:100'],
            'phone'             => ['required', 'string', 'max:20'],
            'package'           => ['required', 'in:' . implode(',', array_keys(self::PACKAGES))],
            'price'             => ['required', 'numeric', 'min:0'],
            'installation_date' => ['required', 'date'],
            'status'            => ['required', 'in:ACTIVE,INACTIVE'],
        ]);

        return redirect()->route('users.create')
            ->with('success', 'User successfully created.');
    }

    public function deactivate(int $id)
    {
        $deactivated = session('deactivated_users', []);

        if (!in_array($id, $deactivated)) {
            $deactivated[] = $id;
            session(['deactivated_users' => $deactivated]);
        }

        return redirect()->back()
            ->with('success', 'User has been deactivated.');
    }

    public function activate(int $id)
    {
        $deactivated = session('deactivated_users', []);
        $deactivated = array_values(array_filter($deactivated, fn($i) => $i !== $id));
        session(['deactivated_users' => $deactivated]);

        return redirect()->back()
            ->with('success', 'User has been activated.');
    }
}
