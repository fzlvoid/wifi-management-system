<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create()
    {
        $packages = Package::whereRaw('is_active IS TRUE')->orderBy('price')->get();

        return view('users.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $adminId = $request->user()->id;

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'address'    => ['required', 'string', 'max:255'],
            'phone'      => ['required', 'string', 'max:20', 'regex:/^[\d\s\+\-\(\)]+$/'],
            'email'      => ['nullable', 'email', 'max:100'],
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'due_date'   => ['required', 'date', 'after_or_equal:today'],
        ]);

        Customer::create([
            'user_id'    => $adminId,
            'package_id' => $validated['package_id'],
            'name'       => $validated['name'],
            'address'    => $validated['address'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'] ?? null,
            'due_date'   => $validated['due_date']
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Customer {$validated['name']} successfully added.");
    }

    public function deactivated(Request $request)
    {
        $adminId = $request->user()->id;

        $users = Customer::with(['package:id,package_name'])
            ->where('user_id', $adminId)
            ->orderBy('name')
            ->get();

        return view('users.deactivated', compact('users'));
    }

    public function deactivate(Request $request, int $id)
    {
        $adminId = $request->user()->id;

        Customer::where('id', $id)
            ->where('user_id', $adminId)
            ->firstOrFail()
            ->update(['is_active' => false]);

        return redirect()->back()
            ->with('success', 'Customer has been deactivated.');
    }

    public function activate(Request $request, int $id)
    {
        $adminId = $request->user()->id;

        Customer::where('id', $id)
            ->where('user_id', $adminId)
            ->firstOrFail()
            ->update(['is_active' => true]);

        return redirect()->back()
            ->with('success', 'Customer has been activated.');
    }
}
