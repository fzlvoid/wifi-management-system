<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard — {{ config('app.name', 'WiFi Manager') }}</title>
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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg bg-cyan-600/20 px-3 py-2.5 text-sm font-medium text-cyan-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Customers --}}
                <div>
                    <p class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        Pelanggan
                    </p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('customers.create') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.create') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Pelanggan
                        </a>
                        <a href="{{ route('customers.deactivated') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.deactivated') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
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

                {{-- Packages --}}
                <div>
                    <p class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 2.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m0 5.625c0 2.278 3.694 4.125 8.25 4.125s8.25-1.847 8.25-4.125" />
                        </svg>
                        Paket WiFi
                    </p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('packages.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            Semua Paket
                        </a>
                        <a href="{{ route('packages.create') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Paket
                        </a>
                    </div>
                </div>

                {{-- Super Admin only --}}
                @if(auth()->user()->role === 'admin')
                <div class="pt-2 border-t border-slate-700/60">
                    <p class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Super Admin</p>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-cyan-600/20 text-cyan-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Kelola User
                    </a>
                </div>
                @endif
            </nav>

            <div class="shrink-0 border-t border-slate-700/60 px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-700 text-xs font-bold text-slate-300 uppercase">
                        {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name ?? auth()->user()->username }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->role === 'admin' ? 'Super Admin' : 'Pemilik RT-RW Net' }}</p>
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

        <label for="nav-open" class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden"></label>

        <div class="flex min-h-screen flex-col lg:pl-64">

            {{-- TOP BAR --}}
            <header class="sticky top-0 z-20 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
                <label for="nav-open" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>

                <div class="flex-1">
                    <h1 class="text-sm font-semibold text-slate-800 sm:text-base">Dashboard Pembayaran</h1>
                    <p class="hidden text-xs text-slate-400 sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>

                <a href="{{ route('customers.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-cyan-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-cyan-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Pelanggan
                </a>
            </header>

            <main class="flex-1 p-4 sm:p-6">

                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- SUMMARY CARDS --}}
                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Total Pelanggan Aktif</p>
                                <p class="mt-1 text-3xl font-bold text-slate-900">{{ $summary['total'] }}</p>
                                <p class="mt-1 text-xs text-slate-400">Pelanggan terdaftar</p>
                            </div>
                            <div class="rounded-lg bg-slate-100 p-2 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-emerald-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Lunas Bulan Ini</p>
                                <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $summary['paid'] }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ now()->format('F Y') }}</p>
                            </div>
                            <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-amber-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Belum Bayar</p>
                                <p class="mt-1 text-3xl font-bold text-amber-500">{{ $summary['unpaid'] }}</p>
                                <p class="mt-1 text-xs text-slate-400">Tagihan aktif</p>
                            </div>
                            <div class="rounded-lg bg-amber-50 p-2 text-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-cyan-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Pendapatan Bulan Ini</p>
                                <p class="mt-1 text-2xl font-bold text-cyan-700">{{ $summary['revenue'] }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ now()->format('F Y') }}</p>
                            </div>
                            <div class="rounded-lg bg-cyan-50 p-2 text-cyan-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLE + OVERDUE PANEL --}}
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_272px]">

                    {{-- CUSTOMER TABLE --}}
                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                        @php $currentStatus = request('status', 'all'); @endphp
                        <div class="flex flex-col gap-3 border-b border-slate-100 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                            <h2 class="font-semibold text-slate-800">Daftar Pelanggan</h2>
                            <div class="flex flex-wrap items-center gap-2">
                                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-1">
                                    <input type="hidden" name="status" value="{{ $currentStatus }}">
                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </span>
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelanggan..."
                                               class="w-40 rounded-lg border border-slate-300 py-1.5 pl-7 pr-3 text-xs text-slate-700 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 sm:w-48">
                                    </div>
                                    <button type="submit" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs text-slate-600 transition hover:bg-slate-50">Cari</button>
                                </form>
                                <div class="flex overflow-hidden rounded-lg border border-slate-300 text-xs font-medium">
                                    <a href="{{ route('dashboard', ['status' => 'all',     'search' => request('search')]) }}"
                                       class="px-3 py-1.5 transition-colors {{ $currentStatus === 'all'     ? 'bg-cyan-600 text-white' : 'text-slate-600 hover:bg-slate-50' }}">Semua</a>
                                    <a href="{{ route('dashboard', ['status' => 'paid',    'search' => request('search')]) }}"
                                       class="border-l border-slate-300 px-3 py-1.5 transition-colors {{ $currentStatus === 'paid'    ? 'bg-cyan-600 text-white' : 'text-slate-600 hover:bg-slate-50' }}">Lunas</a>
                                    <a href="{{ route('dashboard', ['status' => 'unpaid',  'search' => request('search')]) }}"
                                       class="border-l border-slate-300 px-3 py-1.5 transition-colors {{ $currentStatus === 'unpaid'  ? 'bg-cyan-600 text-white' : 'text-slate-600 hover:bg-slate-50' }}">Belum</a>
                                    <a href="{{ route('dashboard', ['status' => 'overdue', 'search' => request('search')]) }}"
                                       class="border-l border-slate-300 px-3 py-1.5 transition-colors {{ $currentStatus === 'overdue' ? 'bg-red-600 text-white'  : 'text-slate-600 hover:bg-slate-50' }}">Overdue</a>
                                </div>
                            </div>
                        </div>

                        {{-- DESKTOP TABLE --}}
                        <div class="hidden overflow-x-auto sm:block">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        <th class="px-5 py-3">Pelanggan</th>
                                        <th class="px-5 py-3">Paket</th>
                                        <th class="px-5 py-3">Tagihan</th>
                                        <th class="px-5 py-3">Jatuh Tempo</th>
                                        <th class="px-5 py-3">Status</th>
                                        <th class="px-5 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($customers as $customer)
                                        @php
                                            $payment = $customer->latestPayment;
                                            $status  = $customer->status;
                                            $rawPhone = preg_replace('/\D+/', '', (string) $customer->phone);
                                            $waPhone  = str_starts_with($rawPhone, '0') ? '62'.substr($rawPhone, 1) : $rawPhone;
                                            if ($waPhone !== '' && ! str_starts_with($waPhone, '62')) { $waPhone = '62'.$waPhone; }
                                            $packageName  = $customer->package->package_name ?? 'Paket WiFi';
                                            
                                            $packagePriceStr = $payment ? number_format($payment->amount, 0, ',', '.') : '0';
                                            $packagePrice = $payment ? 'Rp '.$packagePriceStr : '—';
                                            $dueDate      = $payment ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : '—';
                                            $dueMonth     = $payment ? \Carbon\Carbon::parse($payment->due_date)->locale('id')->translatedFormat('F') : '';
                                            $adminName    = auth()->user()->username ?? 'Admin';

                                            if ($status === 'OVERDUE') {
                                                $billingMsg = "Pelanggan Yth. {$customer->name}\n\nKami belum menerima pembayaran Anda untuk periode {$dueMonth} sebesar Rp. {$packagePriceStr}. Mohon segera melakukan pembayaran.\n\nApabila Anda berhenti berlangganan maka akan dikenakan biaya tambahan berupa penalty sebesar Rp. 1.000.000 dan biaya penarikan perangkat Rp. 100.000.\n\nSelanjutnya Tim {$adminName} akan menyerahkan proses penagihan kepada Petugas Collection lapangan {$adminName}\n\nAbaikan jika Anda sudah melakukan pembayaran\n\nSalam\n{$adminName}";
                                            } else {
                                                $billingMsg = "Pelanggan Yth. {$customer->name}\n\nKami menginformasikan bahwa tagihan internet Anda untuk periode {$dueMonth} sebesar Rp. {$packagePriceStr} telah terbit dan akan jatuh tempo pada {$dueDate}.\n\nMohon berkenan untuk melakukan pembayaran sebelum tanggal jatuh tempo agar layanan internet Anda tidak terganggu.\n\nAbaikan pesan ini jika Anda sudah melakukan pembayaran.\n\nSalam,\n{$adminName}";
                                            }

                                            $waLink       = $waPhone !== '' ? 'https://wa.me/'.$waPhone.'?text='.rawurlencode($billingMsg) : null;
                                        @endphp
                                        <tr class="hover:bg-slate-50/70 transition-colors">
                                            <td class="px-5 py-3.5">
                                                <p class="font-medium text-slate-800">{{ $customer->name }}</p>
                                                <p class="text-xs text-slate-400">{{ $customer->address }}</p>
                                            </td>
                                            <td class="px-5 py-3.5 text-slate-600">{{ $customer->package->package_name ?? '—' }}</td>
                                            <td class="px-5 py-3.5 text-slate-600">{{ $packagePrice }}</td>
                                            <td class="px-5 py-3.5 text-slate-600">{{ $dueDate }}</td>
                                            <td class="px-5 py-3.5">
                                                @if($status === 'PAID')
                                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">PAID</span>
                                                @elseif($status === 'OVERDUE')
                                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-600 ring-1 ring-red-200">OVERDUE</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-600 ring-1 ring-amber-200">UNPAID</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <div class="flex flex-wrap items-center gap-1.5">
                                                    {{-- WhatsApp --}}
                                                    @if($waLink)
                                                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                                           class="inline-flex items-center gap-1 rounded bg-green-500 px-2.5 py-1 text-xs font-semibold text-white hover:bg-green-600 transition-colors">
                                                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-3 w-3 shrink-0">
                                                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.38 1.26 4.8L2.05 22l5.43-1.43c1.37.73 2.92 1.15 4.56 1.15 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.52 14.22c-.23.63-1.35 1.21-1.85 1.26-.48.05-.97.22-3.25-.68-2.74-1.08-4.49-3.86-4.63-4.04-.14-.18-1.14-1.52-1.14-2.9 0-1.37.72-2.05 1-2.34.27-.28.59-.35.79-.35h.54c.18 0 .42-.06.66.5.25.59.84 2.06.91 2.21.07.15.12.32.02.51-.09.19-.14.3-.28.47-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.72 1.19 1.54 1.93 1.06.95 1.95 1.24 2.23 1.38.28.14.44.12.6-.07.16-.19.7-.82.89-1.1.19-.28.37-.23.63-.14.26.09 1.64.77 1.92.91.28.14.46.2.53.32.07.12.07.68-.16 1.31z"/>
                                                            </svg>
                                                            Chat
                                                        </a>
                                                    @endif

                                                    {{-- Mark as Paid / Reversal --}}
                                                    @if($status === 'PAID')
                                                        <form method="POST" action="{{ route('dashboard.reversal', $customer->id) }}">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('Batalkan status PAID ke UNPAID?')"
                                                                    class="rounded border border-slate-300 bg-slate-50 px-2.5 py-1 text-xs font-medium text-slate-600 hover:bg-slate-100 transition-colors">
                                                                Reversal
                                                            </button>
                                                        </form>
                                                    @elseif($payment)
                                                        <button type="button" id="pay-btn-d-{{ $customer->id }}"
                                                                onclick="showPayForm('d-{{ $customer->id }}')"
                                                                class="rounded border border-amber-300 bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 hover:bg-amber-100 transition-colors">
                                                            Mark as Paid
                                                        </button>
                                                        <form id="pay-form-d-{{ $customer->id }}" method="POST"
                                                              action="{{ route('dashboard.pay', $customer->id) }}" class="hidden">
                                                            @csrf
                                                            <div class="flex items-center gap-1.5">
                                                                <input type="date" name="payment_date" value="{{ now()->format('Y-m-d') }}"
                                                                       class="rounded border border-slate-300 px-1.5 py-1 text-xs text-slate-700 focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                                                <button type="submit" class="rounded bg-cyan-600 px-2.5 py-1 text-xs font-medium text-white hover:bg-cyan-700">Confirm</button>
                                                                <button type="button" onclick="hidePayForm('d-{{ $customer->id }}')"
                                                                        class="rounded border border-slate-300 px-2 py-1 text-xs text-slate-500 hover:bg-slate-50">✕</button>
                                                            </div>
                                                        </form>
                                                    @endif


                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada pelanggan ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- MOBILE CARDS --}}
                        <div class="divide-y divide-slate-100 sm:hidden">
                            @forelse($customers as $customer)
                                @php
                                    $payment = $customer->latestPayment;
                                    $status  = $customer->status;
                                    $rawPhone = preg_replace('/\D+/', '', (string) $customer->phone);
                                    $waPhone  = str_starts_with($rawPhone, '0') ? '62'.substr($rawPhone, 1) : $rawPhone;
                                    if ($waPhone !== '' && ! str_starts_with($waPhone, '62')) { $waPhone = '62'.$waPhone; }
                                    $packageName  = $customer->package->package_name ?? 'Paket WiFi';
                                    
                                    $packagePriceStr = $payment ? number_format($payment->amount, 0, ',', '.') : '0';
                                    $packagePrice = $payment ? 'Rp '.$packagePriceStr : '—';
                                    $dueDate      = $payment ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : '—';
                                    $dueMonth     = $payment ? \Carbon\Carbon::parse($payment->due_date)->locale('id')->translatedFormat('F') : '';
                                    $adminName    = auth()->user()->username ?? 'Admin';

                                    if ($status === 'OVERDUE') {
                                        $billingMsg = "Pelanggan Yth. {$customer->name}\n\nKami belum menerima pembayaran Anda untuk periode {$dueMonth} sebesar Rp. {$packagePriceStr}. Mohon segera melakukan pembayaran.\n\nApabila Anda berhenti berlangganan maka akan dikenakan biaya tambahan berupa penalty sebesar Rp. 1.000.000 dan biaya penarikan perangkat Rp. 100.000.\n\nSelanjutnya Tim {$adminName} akan menyerahkan proses penagihan kepada Petugas Collection lapangan {$adminName}\n\nAbaikan jika Anda sudah melakukan pembayaran\n\nSalam\n{$adminName}";
                                    } else {
                                        $billingMsg = "Pelanggan Yth. {$customer->name}\n\nKami menginformasikan bahwa tagihan internet Anda untuk periode {$dueMonth} sebesar Rp. {$packagePriceStr} telah terbit dan akan jatuh tempo pada {$dueDate}.\n\nMohon berkenan untuk melakukan pembayaran sebelum tanggal jatuh tempo agar layanan internet Anda tidak terganggu.\n\nAbaikan pesan ini jika Anda sudah melakukan pembayaran.\n\nSalam,\n{$adminName}";
                                    }

                                    $waLink       = $waPhone !== '' ? 'https://wa.me/'.$waPhone.'?text='.rawurlencode($billingMsg) : null;
                                @endphp
                                <div class="px-4 py-3">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <p class="font-medium text-slate-800">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $customer->address }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $customer->package->package_name ?? '—' }}</p>
                                        </div>
                                        @if($status === 'PAID')
                                            <span class="inline-flex shrink-0 items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">PAID</span>
                                        @elseif($status === 'OVERDUE')
                                            <span class="inline-flex shrink-0 items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-600 ring-1 ring-red-200">OVERDUE</span>
                                        @else
                                            <span class="inline-flex shrink-0 items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-600 ring-1 ring-amber-200">UNPAID</span>
                                        @endif
                                    </div>
                                    <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                                        <div>
                                            <p class="text-slate-400">Tagihan</p>
                                            <p class="font-medium text-slate-700">{{ $payment ? 'Rp '.number_format($payment->amount, 0, ',', '.') : '—' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-slate-400">Jatuh Tempo</p>
                                            <p class="font-medium text-slate-700">{{ $payment ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : '—' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2.5 flex flex-wrap items-center gap-2">
                                        {{-- WhatsApp --}}
                                        @if($waLink)
                                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1 rounded bg-green-500 px-2.5 py-1 text-xs font-semibold text-white hover:bg-green-600 transition-colors">
                                                <svg viewBox="0 0 24 24" fill="currentColor" class="h-3 w-3 shrink-0">
                                                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.38 1.26 4.8L2.05 22l5.43-1.43c1.37.73 2.92 1.15 4.56 1.15 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.52 14.22c-.23.63-1.35 1.21-1.85 1.26-.48.05-.97.22-3.25-.68-2.74-1.08-4.49-3.86-4.63-4.04-.14-.18-1.14-1.52-1.14-2.9 0-1.37.72-2.05 1-2.34.27-.28.59-.35.79-.35h.54c.18 0 .42-.06.66.5.25.59.84 2.06.91 2.21.07.15.12.32.02.51-.09.19-.14.3-.28.47-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.72 1.19 1.54 1.93 1.06.95 1.95 1.24 2.23 1.38.28.14.44.12.6-.07.16-.19.7-.82.89-1.1.19-.28.37-.23.63-.14.26.09 1.64.77 1.92.91.28.14.46.2.53.32.07.12.07.68-.16 1.31z"/>
                                                </svg>
                                                Chat
                                            </a>
                                        @endif

                                        @if($status !== 'PAID' && $payment)
                                            <button type="button" id="pay-btn-m-{{ $customer->id }}"
                                                    onclick="showPayForm('m-{{ $customer->id }}')"
                                                    class="rounded border border-amber-300 bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 hover:bg-amber-100">
                                                Mark as Paid
                                            </button>
                                            <form id="pay-form-m-{{ $customer->id }}" method="POST"
                                                  action="{{ route('dashboard.pay', $customer->id) }}" class="hidden">
                                                @csrf
                                                <div class="flex items-center gap-1.5">
                                                    <input type="date" name="payment_date" value="{{ now()->format('Y-m-d') }}"
                                                           class="rounded border border-slate-300 px-1.5 py-1 text-xs">
                                                    <button type="submit" class="rounded bg-cyan-600 px-2.5 py-1 text-xs font-medium text-white">Confirm</button>
                                                    <button type="button" onclick="hidePayForm('m-{{ $customer->id }}')"
                                                            class="rounded border border-slate-300 px-2 py-1 text-xs text-slate-500">✕</button>
                                                </div>
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-8 text-center text-sm text-slate-400">Tidak ada pelanggan ditemukan.</div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
                        @if($customers->hasPages())
                            <div class="flex items-center justify-between border-t border-slate-100 px-5 py-3">
                                <p class="text-xs text-slate-400">
                                    Menampilkan {{ $customers->firstItem() }}–{{ $customers->lastItem() }} dari {{ $customers->total() }}
                                </p>
                                <div class="flex items-center gap-1 text-xs">
                                    @if($customers->onFirstPage())
                                        <span class="cursor-not-allowed rounded-md border border-slate-200 px-2.5 py-1.5 text-slate-300">‹ Prev</span>
                                    @else
                                        <a href="{{ $customers->previousPageUrl() }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-slate-600 hover:bg-slate-50">‹ Prev</a>
                                    @endif
                                    @for($i = 1; $i <= $customers->lastPage(); $i++)
                                        <a href="{{ $customers->url($i) }}"
                                           class="rounded-md px-2.5 py-1.5 {{ $i === $customers->currentPage() ? 'bg-cyan-600 text-white' : 'border border-slate-300 text-slate-600 hover:bg-slate-50' }}">{{ $i }}</a>
                                    @endfor
                                    @if($customers->hasMorePages())
                                        <a href="{{ $customers->nextPageUrl() }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-slate-600 hover:bg-slate-50">Next ›</a>
                                    @else
                                        <span class="cursor-not-allowed rounded-md border border-slate-200 px-2.5 py-1.5 text-slate-300">Next ›</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- OVERDUE WIDGET --}}
                    <div class="flex flex-col gap-5 sm:flex-row sm:gap-4 xl:flex-col">
                        <div class="flex-1 rounded-xl border border-red-100 bg-white p-4 shadow-sm sm:p-5">
                            <div class="mb-3 flex items-center justify-between">
                                <h3 class="font-semibold text-slate-800">Overdue / Menunggak</h3>
                                <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-600">
                                    {{ $overdueCustomers->count() }}
                                </span>
                            </div>
                            @if($overdueCustomers->isEmpty())
                                <p class="text-xs text-slate-400 text-center py-4">Tidak ada tunggakan 🎉</p>
                            @else
                                <ul class="space-y-2">
                                    @foreach($overdueCustomers as $overdue)
                                        @php $op = $overdue->latestPayment; @endphp
                                        <li class="flex items-center gap-3 rounded-lg bg-red-50 px-3 py-2.5">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-xs font-bold text-red-600">
                                                {{ strtoupper(substr($overdue->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="truncate text-sm font-medium text-slate-700">{{ $overdue->name }}</p>
                                                <p class="text-xs text-red-500">
                                                    Telat {{ $op ? \Carbon\Carbon::parse($op->due_date)->diffForHumans() : '—' }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- Payment Stats --}}
                        <div class="flex-1 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                            <h3 class="mb-4 font-semibold text-slate-800">Status Pembayaran</h3>
                            @php
                                $total = $summary['total'] ?: 1;
                                $paidPct   = round(($summary['paid']   / $total) * 100);
                                $unpaidPct = round(($summary['unpaid'] / $total) * 100);
                            @endphp
                            <div class="space-y-4">
                                <div>
                                    <div class="mb-1.5 flex items-center justify-between text-xs">
                                        <span class="font-medium text-slate-600">Lunas</span>
                                        <span class="font-semibold text-emerald-600">{{ $paidPct }}%</span>
                                    </div>
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-2 rounded-full bg-emerald-500 transition-all" style="width:{{ $paidPct }}%"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-400">{{ $summary['paid'] }} pelanggan</p>
                                </div>
                                <div>
                                    <div class="mb-1.5 flex items-center justify-between text-xs">
                                        <span class="font-medium text-slate-600">Belum Bayar</span>
                                        <span class="font-semibold text-amber-500">{{ $unpaidPct }}%</span>
                                    </div>
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-2 rounded-full bg-amber-400 transition-all" style="width:{{ $unpaidPct }}%"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-400">{{ $summary['unpaid'] }} pelanggan</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-lg bg-slate-50 px-3 py-2.5 text-center text-xs text-slate-500">
                                {{ $summary['total'] }} total pelanggan aktif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <script>
            function showPayForm(id) {
                document.getElementById('pay-btn-' + id).classList.add('hidden');
                document.getElementById('pay-form-' + id).classList.remove('hidden');
            }
            function hidePayForm(id) {
                document.getElementById('pay-form-' + id).classList.add('hidden');
                document.getElementById('pay-btn-' + id).classList.remove('hidden');
            }
        </script>
    </body>
</html>
