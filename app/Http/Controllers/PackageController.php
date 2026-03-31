<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::withCount('customers')->orderBy('price')->get();

        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        return view('packages.form', ['package' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => ['required', 'string', 'max:100', 'unique:packages,package_name'],
            'speed'        => ['required', 'integer', 'min:1', 'max:10000'],
            'price'        => ['required', 'numeric', 'min:0'],
            'description'  => ['nullable', 'string', 'max:500'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', "Package \"{$validated['package_name']}\" successfully created.");
    }

    public function edit(Package $package)
    {
        return view('packages.form', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'package_name' => ['required', 'string', 'max:100', "unique:packages,package_name,{$package->id}"],
            'speed'        => ['required', 'integer', 'min:1', 'max:10000'],
            'price'        => ['required', 'numeric', 'min:0'],
            'description'  => ['nullable', 'string', 'max:500'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', "Package \"{$package->package_name}\" successfully updated.");
    }

    public function destroy(Package $package)
    {
        if ($package->customers()->exists()) {
            return redirect()->route('packages.index')
                ->with('error', "Cannot delete \"{$package->package_name}\" — it still has customers assigned.");
        }

        $name = $package->package_name;
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', "Package \"{$name}\" deleted.");
    }
}
