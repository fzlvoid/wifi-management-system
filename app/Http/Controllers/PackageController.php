<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::withCount('customers')->orderBy('price')->get();

        return view('packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('packages.form', ['package' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_name' => ['required', 'string', 'max:100'],
            'speed' => ['required', 'integer', 'min:1', 'max:10000'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['is_active'] = DB::raw('TRUE');
        $validated['user_id'] = $request->user()->id;

        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$validated['package_name']}\" berhasil dibuat.");
    }

    public function edit(Package $package): View
    {
        return view('packages.form', compact('package'));
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'package_name' => ['required', 'string', 'max:100', "unique:packages,package_name,{$package->id}"],
            'speed' => ['required', 'integer', 'min:1', 'max:10000'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true) ? DB::raw('TRUE') : DB::raw('FALSE');

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$package->package_name}\" berhasil diperbarui.");
    }

    public function destroy(Package $package): RedirectResponse
    {
        if ($package->customers()->exists()) {
            return redirect()->route('packages.index')
                ->with('error', "Tidak bisa menghapus \"{$package->package_name}\" — masih ada pelanggan aktif.");
        }

        $name = $package->package_name;
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', "Paket \"{$name}\" berhasil dihapus.");
    }
}
