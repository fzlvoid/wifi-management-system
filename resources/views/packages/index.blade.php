<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Paket — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <input type="checkbox" id="nav-open" class="peer/nav sr-only">

        <x-sidebar />

        <label for="nav-open"
               class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden">
        </label>

        <div class="flex min-h-screen flex-col lg:pl-64">

            <header class="sticky top-0 z-20 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
                <label for="nav-open" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>
                <div class="flex-1">
                    <h1 class="text-sm font-semibold text-slate-800 sm:text-base">WiFi Packages</h1>
                    <p class="hidden text-xs text-slate-400 sm:block">Manage all available WiFi packages</p>
                </div>
                <div class="hidden items-center gap-3 sm:flex">
                    <span class="text-xs text-slate-500">Logged in as <strong class="text-slate-700">{{ auth()->user()->name ?? auth()->user()->username ?? 'Admin' }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-slate-400 hover:text-slate-800">Logout</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">

                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Header row --}}
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Semua Paket</h2>
                        <p class="mt-0.5 text-sm text-slate-500">{{ $packages->count() }} package{{ $packages->count() !== 1 ? 's' : '' }} registered</p>
                    </div>
                    <a href="{{ route('packages.create') }}"
                       class="inline-flex items-center gap-1.5 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>Tambah Paket</a>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    {{-- Mobile: card list --}}
                    <div class="divide-y divide-slate-100 sm:hidden">
                        @forelse ($packages as $package)
                            <div class="px-4 py-3">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $package->package_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $package->speed }} Mbps &middot; Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                        @if ($package->description)
                                            <p class="mt-1 text-xs text-slate-400">{{ Str::limit($package->description, 60) }}</p>
                                        @endif
                                    </div>
                                    @if ($package->is_active)
                                        <span class="inline-flex shrink-0 items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                    @else
                                        <span class="inline-flex shrink-0 items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500 ring-1 ring-slate-200">Inactive</span>
                                    @endif
                                </div>
                                <p class="mt-1.5 text-xs text-slate-400">{{ $package->customers_count }} customer{{ $package->customers_count !== 1 ? 's' : '' }}</p>
                                <div class="mt-2.5 flex items-center gap-2">
                                    <a href="{{ route('packages.edit', $package) }}"
                                       class="rounded border border-cyan-300 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700 hover:bg-cyan-100 transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('packages.destroy', $package) }}"
                                          onsubmit="return confirm('Delete package \'{{ addslashes($package->package_name) }}\'? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded border border-red-300 bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-10 text-center text-sm text-slate-400">
                                No packages yet. <a href="{{ route('packages.create') }}" class="text-cyan-600 hover:underline">Add one now.</a>
                            </div>
                        @endforelse
                    </div>

                    {{-- Desktop: table --}}
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="px-5 py-3">Package Name</th>
                                    <th class="px-5 py-3">Speed</th>
                                    <th class="px-5 py-3">Price / Month</th>
                                    <th class="px-5 py-3">Description</th>
                                    <th class="px-5 py-3">Customers</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($packages as $package)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <p class="font-medium text-slate-800">{{ $package->package_name }}</p>
                                        </td>
                                        <td class="px-5 py-3.5 text-slate-600">{{ $package->speed }} Mbps</td>
                                        <td class="px-5 py-3.5 font-medium text-slate-700">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                                        <td class="px-5 py-3.5 text-slate-500 max-w-xs">
                                            {{ $package->description ? Str::limit($package->description, 50) : '—' }}
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                                {{ $package->customers_count }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if ($package->is_active)
                                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500 ring-1 ring-slate-200">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('packages.edit', $package) }}"
                                                   class="rounded border border-cyan-300 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700 hover:bg-cyan-100 transition-colors">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('packages.destroy', $package) }}"
                                                      onsubmit="return confirm('Delete package \'{{ addslashes($package->package_name) }}\'? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="rounded border border-red-300 bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition-colors">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-400">
                                            No packages yet. <a href="{{ route('packages.create') }}" class="text-cyan-600 hover:underline">Add one now.</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </main>
        </div>

    </body>
</html>
