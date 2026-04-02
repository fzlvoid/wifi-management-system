<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tambah Pelanggan — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        {{-- ============================================================
             MOBILE SIDEBAR TOGGLE (CSS-only, no JS)
        ============================================================ --}}
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
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                <div>
                    <p class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        Pelanggan
                    </p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('customers.create') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                                  {{ request()->routeIs('customers.create') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}
                                  transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Pelanggan
                        </a>
                        <a href="{{ route('customers.deactivated') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                                  {{ request()->routeIs('customers.deactivated') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}
                                  transition-colors">
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 2.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m0 5.625c0 2.278 3.694 4.125 8.25 4.125s8.25-1.847 8.25-4.125" />
                        </svg>
                        Paket
                    </p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('packages.index') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            Semua Paket
                        </a>
                        <a href="{{ route('packages.create') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Paket
                        </a>
                    </div>
                </div>

                <a href="#"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    Pembayaran
                </a>

                <a href="#"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Laporan
                </a>

                <a href="#"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Pengaturan
                </a>
            </nav>

            <div class="border-t border-slate-700/60 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-700 text-xs font-bold text-slate-300 uppercase">
                            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-medium text-white">{{ auth()->user()->username }}</p>
                            <p class="text-xs text-slate-400">Administrator</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="rounded-md p-1.5 text-slate-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Mobile overlay --}}
        <label for="nav-open"
               class="fixed inset-0 z-30 bg-slate-900/50 opacity-0 pointer-events-none transition-opacity
                      peer-checked/nav:opacity-100 peer-checked/nav:pointer-events-auto lg:hidden">
        </label>

        {{-- ===== MAIN WRAPPER ===== --}}
        <div class="flex min-h-screen flex-col lg:pl-64">

            {{-- Top bar --}}
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
                        <span class="font-medium text-slate-800">Tambah Pelanggan</span>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-4 sm:p-6">

                <div class="mb-5">
                    <h1 class="text-lg font-semibold text-slate-900">Tambah Pelanggan Baru</h1>
                    <p class="mt-0.5 text-sm text-slate-500">Daftarkan pelanggan WiFi baru ke dalam sistem.</p>
                </div>

                {{-- Success message --}}
                @if (session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form card --}}
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <form method="POST" action="{{ route('customers.store') }}" novalidate>
                        @csrf

                        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

                            {{-- Full Name --}}
                            <div>
                                <label for="name" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Sarah Johnson"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div>
                                <label for="address" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="address"
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    placeholder="e.g. Jl. Merdeka No. 12, Jakarta"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('address') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('address')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div>
                                <label for="phone" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="phone"
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="e.g. 081234567890"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('phone') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Email <span class="text-slate-400 font-normal">(opsional)</span>
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="e.g. customer@email.com"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- WiFi Package --}}
                            <div>
                                <label for="package_id" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Paket WiFi <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="package_id"
                                    name="package_id"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('package_id') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                    <option value="">— Pilih Paket —</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->package_name }} — Rp {{ number_format($package->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Billing Cycle Date --}}
                            <div>
                                <label for="billing_cycle_date" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Tanggal Siklus Tagihan <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="billing_cycle_date"
                                    name="billing_cycle_date"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('billing_cycle_date') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                    <option value="">— Pilih tanggal (1–28) —</option>
                                    @for($day = 1; $day <= 28; $day++)
                                        <option value="{{ $day }}" {{ old('billing_cycle_date') == $day ? 'selected' : '' }}>
                                            Tanggal {{ $day }} setiap bulan
                                        </option>
                                    @endfor
                                </select>
                                <p class="mt-1 text-xs text-slate-400">Tagihan akan dibuat otomatis H-5 sebelum tanggal ini.</p>
                                @error('billing_cycle_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- First Billing Date --}}
                            <div>
                                <label for="first_billing_date" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Tanggal Tagihan Pertama (Due Date) <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="first_billing_date" name="first_billing_date" value="{{ old('first_billing_date', now()->format('Y-m-d')) }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition {{ $errors->has('first_billing_date') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                <p class="mt-1 text-xs text-slate-400">Pilih tanggal spesifik untuk jatuh tempo tagihan bulan pertama.</p>
                                @error('first_billing_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Initial Payment Status --}}
                            <div class="sm:col-span-2 mt-2">
                                <label class="mb-2 block text-xs font-medium text-slate-700">Setoran Awal (Registrasi) <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-6">
                                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                        <input type="radio" name="initial_payment_status" value="UNPAID"
                                               class="h-4 w-4 border-slate-300 text-cyan-600 focus:ring-cyan-500" {{ old('initial_payment_status', 'UNPAID') === 'UNPAID' ? 'checked' : '' }}>
                                        Belum Bayar (Masuk Tagihan)
                                    </label>
                                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                        <input type="radio" name="initial_payment_status" value="PAID"
                                               class="h-4 w-4 border-slate-300 text-cyan-600 focus:ring-cyan-500" {{ old('initial_payment_status') === 'PAID' ? 'checked' : '' }}>
                                        Langsung Lunas Pertama
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-slate-400">Tentukan apakah pendaftaran ini pelanggan sudah langsung membayar bulan pertamanya.</p>
                                @error('initial_payment_status')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="mt-7 flex items-center gap-3 border-t border-slate-100 pt-5">
                            <button
                                type="submit"
                                class="rounded-lg bg-cyan-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2"
                            >
                                Simpan Pelanggan
                            </button>
                            <a
                                href="{{ route('dashboard') }}"
                                class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50"
                            >
                                Kembali ke Dashboard
                            </a>
                        </div>

                    </form>
                </div>

            </main>
        </div>

    </body>
</html>
