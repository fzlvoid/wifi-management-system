<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $package ? 'Edit' : 'Add' }} Package — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <input type="checkbox" id="nav-open" class="peer/nav sr-only">

        {}
        <x-sidebar />

        <label for="nav-open"
               class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden">
        </label>

        <div class="flex min-h-screen flex-col lg:pl-64">

            <header class="sticky top-0 z-20 flex h-14 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <label for="nav-open" class="cursor-pointer rounded-md p-1.5 text-slate-500 hover:bg-slate-100 lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </label>
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Dashboard</a>
                        <span>/</span>
                        <a href="{{ route('packages.index') }}" class="hover:text-slate-800 transition-colors">Paket</a>
                        <span>/</span>
                        <span class="font-medium text-slate-800">{{ $package ? 'Edit' : 'Add' }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">

                <div class="mb-5">
                    <h1 class="text-lg font-semibold text-slate-900">
                        {{ $package ? 'Edit Package' : 'Add New Package' }}
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-500">
                        {{ $package ? "Update details for \"{$package->package_name}\"." : 'Register a new WiFi package.' }}
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <form method="POST"
                          action="{{ $package ? route('packages.update', $package) : route('packages.store') }}"
                          novalidate>
                        @csrf
                        @if ($package)
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

                            {{-- Package Name --}}
                            <div class="sm:col-span-2">
                                <label for="package_name" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Package Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="package_name"
                                    type="text"
                                    name="package_name"
                                    value="{{ old('package_name', $package?->package_name) }}"
                                    placeholder="e.g. FastNet 50Mbps"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('package_name') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('package_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Speed --}}
                            <div>
                                <label for="speed" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Speed (Mbps) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="speed"
                                    type="number"
                                    name="speed"
                                    value="{{ old('speed', $package?->speed) }}"
                                    placeholder="e.g. 50"
                                    min="1"
                                    max="10000"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('speed') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('speed')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div>
                                <label for="price" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Price / Month (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="price"
                                    type="number"
                                    name="price"
                                    value="{{ old('price', $package?->price) }}"
                                    placeholder="e.g. 300000"
                                    min="0"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('price') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('price')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="sm:col-span-2">
                                <label for="description" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Description <span class="text-slate-400 font-normal">(optional)</span>
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="e.g. Ideal for families, includes streaming support..."
                                    class="w-full resize-none rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('description') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >{{ old('description', $package?->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Is Active --}}
                            <div class="sm:col-span-2">
                                <label class="flex cursor-pointer items-center gap-3">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', $package ? $package->is_active : true) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500"
                                    >
                                    <span class="text-sm font-medium text-slate-700">Active</span>
                                    <span class="text-xs text-slate-400">— inactive packages won't appear in the Add Customer form</span>
                                </label>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="mt-7 flex items-center gap-3 border-t border-slate-100 pt-5">
                            <button
                                type="submit"
                                class="rounded-lg bg-cyan-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2"
                            >
                                {{ $package ? 'Update Package' : 'Save Package' }}
                            </button>
                            <a href="{{ route('packages.index') }}"
                               class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>

            </main>
        </div>

    </body>
</html>
