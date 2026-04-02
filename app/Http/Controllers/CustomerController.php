<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use App\Http\Requests\StoreCustomerRequest;

class CustomerController extends Controller
{
    public function create(): View
    {
        $packages = Package::whereRaw('is_active IS TRUE')->orderBy('price')->get();

        return view('customers.create', compact('packages'));
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $adminId = $request->user()->id;

        $package = Package::findOrFail($validated['package_id']);

        DB::transaction(function () use ($validated, $package, $adminId) {
            $customer = Customer::create([
                'user_id' => $adminId,
                'package_id' => $validated['package_id'],
                'name' => $validated['name'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'billing_cycle_date' => $validated['billing_cycle_date'],
                'is_active' => DB::raw('TRUE'),
            ]);

            // Custom initial billing date requested by admin
            $dueDate = \Carbon\Carbon::parse($validated['first_billing_date'])->startOfDay();

            Payment::create([
                'customer_id' => $customer->id,
                'amount' => $package->price,
                'status' => $validated['initial_payment_status'],
                'due_date' => $dueDate->toDateString(),
                'payment_date' => $validated['initial_payment_status'] === 'PAID' ? now()->toDateString() : null,
                'billing_month' => $dueDate->format('Y-m'),
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', "Pelanggan {$validated['name']} berhasil ditambahkan.");
    }

    public function deactivated(Request $request): View
    {
        $customers = Customer::with(['package'])
            ->whereRaw('is_active IS FALSE')
            ->orderBy('name')
            ->get();

        return view('customers.deactivated', compact('customers'));
    }

    public function deleteList(Request $request): View
    {
        $customers = Customer::with(['package'])->orderBy('name')->get();

        return view('customers.delete', compact('customers'));
    }

    public function deactivate(Request $request, int $id): RedirectResponse
    {
        Customer::findOrFail($id)->update(['is_active' => DB::raw('FALSE')]);

        return redirect()->back()->with('success', 'Pelanggan berhasil dinonaktifkan.');
    }

    public function activate(Request $request, int $id): RedirectResponse
    {
        Customer::findOrFail($id)->update(['is_active' => DB::raw('TRUE')]);

        return redirect()->back()->with('success', 'Pelanggan berhasil diaktifkan.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        Customer::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus permanen.');
    }
}
