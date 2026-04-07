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

        <x-sidebar />

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
                                <label for="name" class="mb-1.5 block text-sm sm:text-xs font-medium text-slate-700">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Sarah Johnson"
                                    class="w-full rounded-lg border px-3.5 py-2.5 sm:py-2 text-base sm:text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div>
                                <label for="address" class="mb-1.5 block text-sm sm:text-xs font-medium text-slate-700">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="address"
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    placeholder="e.g. Jl. Merdeka No. 12, Jakarta"
                                    class="w-full rounded-lg border px-3.5 py-2.5 sm:py-2 text-base sm:text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('address') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('address')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div>
                                <label for="phone" class="mb-1.5 block text-sm sm:text-xs font-medium text-slate-700">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="phone"
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="e.g. 081234567890"
                                    class="w-full rounded-lg border px-3.5 py-2.5 sm:py-2 text-base sm:text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('phone') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-1.5 block text-sm sm:text-xs font-medium text-slate-700">
                                    Email <span class="text-slate-400 font-normal">(opsional)</span>
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="e.g. customer@email.com"
                                    class="w-full rounded-lg border px-3.5 py-2.5 sm:py-2 text-base sm:text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- WiFi Package --}}
                            <div>
                                <label for="package_id" class="mb-1.5 block text-sm sm:text-xs font-medium text-slate-700">
                                    Paket WiFi <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="package_id"
                                    name="package_id"
                                    class="w-full rounded-lg border px-3.5 py-2.5 sm:py-2 text-base sm:text-sm text-slate-800 outline-none transition
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

                            {{-- Due Date --}}
                            <div>
                                <label for="due_date" class="mb-1.5 block text-sm sm:text-xs font-medium text-slate-700">
                                    Tanggal Jatuh Tempo <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', now()->addMonth()->format('Y-m-d')) }}"
                                       class="w-full rounded-lg border px-3.5 py-2.5 sm:py-2 text-base sm:text-sm text-slate-800 outline-none transition {{ $errors->has('due_date') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                <div class="mt-2 rounded-lg border border-cyan-100 bg-cyan-50 px-3 py-2 text-xs leading-relaxed text-cyan-800">
                                    <p class="font-semibold">Info Jatuh Tempo</p>
                                    <p class="mt-1">Saat registrasi, bulan pertama langsung tercatat <span class="font-semibold">lunas</span>. Karena itu, tanggal jatuh tempo yang tampil di dashboard otomatis untuk <span class="font-semibold">bulan berikutnya (+1 bulan)</span>.</p>
                                </div>
                                @error('due_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="mt-8 flex flex-col sm:flex-row items-center gap-3 border-t border-slate-100 pt-6">
                            <button
                                type="submit"
                                class="w-full sm:w-auto flex justify-center items-center rounded-lg bg-cyan-600 px-6 py-3 sm:py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2"
                            >
                                Simpan Pelanggan
                            </button>
                            <a
                                href="{{ route('dashboard') }}"
                                class="w-full sm:w-auto flex justify-center items-center rounded-lg border border-slate-300 px-6 py-3 sm:py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50"
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
