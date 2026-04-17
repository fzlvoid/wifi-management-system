<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::withCount('subscriptions')->orderBy('price')->get();

        return view('packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('packages.form', ['package' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['is_active'] = DB::raw('true');
        $validated['user_id'] = $request->user()->id;

        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$validated['name']}\" berhasil dibuat.");
    }

    public function edit(Package $package): View
    {
        return view('packages.form', compact('package'));
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$package->name}\" berhasil diperbarui.");
    }

    public function setActive(Package $package): RedirectResponse
    {
        DB::table('packages')
            ->where('id', $package->id)
            ->update([
                'is_active' => DB::raw('NOT is_active'),
                'updated_at' => now(),
            ]);

        $package->refresh();

        $status = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$package->name}\" berhasil {$status}.");
    }

    public function destroy(Package $package): RedirectResponse
    {
        if ($package->subscriptions()->exists()) {
            return redirect()->route('packages.index')
                ->with('error', "Tidak bisa menghapus \"{$package->name}\" — masih ada pelanggan yang berlangganan paket ini.");
        }

        $name = $package->name;
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$name}\" berhasil dihapus.");
    }
}
