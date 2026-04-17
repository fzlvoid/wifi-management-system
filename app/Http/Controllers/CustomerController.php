<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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
        $dueDate = Carbon::parse($validated['due_date'])->startOfDay();

        DB::transaction(function () use ($validated, $package, $adminId, $dueDate) {
            $customer = Customer::create([
                'user_id' => $adminId,
                'name' => $validated['name'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'is_active' => DB::raw('TRUE'),
            ]);

            $subscription = CustomerSubscription::create([
                'user_id' => $adminId,
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'start_date' => $dueDate->toDateString(),
                'end_date' => $dueDate->copy()->addMonth()->toDateString(),
                'billing_cycle_date' => (int) $dueDate->day,
                'is_active' => DB::raw('TRUE'),
            ]);

            Billing::create([
                'user_id' => $adminId,
                'customer_id' => $customer->id,
                'subscription_id' => $subscription->id,
                'amount' => $package->price,
                'status' => 'paid',
                'due_date' => $dueDate->copy()->addMonth()->toDateString(),
                'payment_date' => now(),
                'billing_month' => $dueDate->month,
                'billing_year' => $dueDate->year,
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', "Pelanggan {$validated['name']} berhasil ditambahkan.");
    }

    public function history(Customer $customer): View
    {
        $billings = $customer->billings()
            ->with(['subscription.package'])
            ->orderBy('billing_year', 'desc')
            ->orderBy('billing_month', 'desc')
            ->paginate(15);

        return view('customers.history', compact('customer', 'billings'));
    }

    public function deleteList(Request $request): View
    {
        $customers = Customer::orderBy('name')->get();

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
