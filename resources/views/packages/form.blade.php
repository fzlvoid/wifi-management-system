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

        {{-- ===== SIDEBAR ===== --}}
        <aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-slate-900 text-white
                      -translate-x-full transition-transform duration-200
                      peer-checked/nav:translate-x-0
                      lg:translate-x-0">

            <div class="flex h-16 shrink-0 items-center justify-between px-5 border-b border-slate-700/60">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 text-white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-white">{{ config('app.name', 'WiFi Manager') }}</span>
                </div>
                <label for="nav-open" class="cursor-pointer rounded-md p-1 text-slate-400 hover:text-white lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </label>
            </div>

            <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-4">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Customer --}}
                <div>
                    <p class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>Pelanggan</p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('customers.create') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.create') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Pelanggan
                        </a>
                        <a href="{{ route('customers.deactivated') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.deactivated') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Nonaktif
                        </a>
                        <a href="{{ route('customers.delete_list') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.delete_list') ? 'bg-red-500/20 text-red-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Hapus Pelanggan
                        </a>
                    </div>
                </div>

                {{-- Packages (active) --}}
                <div>
                    <p class="flex items-center gap-3 rounded-lg bg-cyan-600/20 px-3 py-2.5 text-sm font-medium text-cyan-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 2.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m0 5.625c0 2.278 3.694 4.125 8.25 4.125s8.25-1.847 8.25-4.125" />
                        </svg>Paket</p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('packages.index') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>Semua Paket</a>
                        <a href="{{ route('packages.create') }}"
                           class="flex items-center gap-2 rounded-lg {{ request()->routeIs('packages.create') || request()->routeIs('packages.edit') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} px-3 py-2 text-sm font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>Tambah Paket</a>
                    </div>
                </div>
            </nav>

            <div class="shrink-0 border-t border-slate-700/60 px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-700 text-xs font-bold text-slate-300 uppercase">
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-white">{{ auth()->user()->username }}</p>
                        <p class="text-xs text-slate-500">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="rounded-md p-1.5 text-slate-500 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

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
