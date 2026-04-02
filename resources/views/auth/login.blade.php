<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'WiFi Manager') }} — Masuk</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <div class="grid min-h-screen lg:grid-cols-[1fr_480px]">

            {{-- ===================== LEFT: HERO ===================== --}}
            <div class="relative hidden overflow-hidden lg:flex lg:flex-col lg:justify-center lg:p-12">

                {{-- Gradient layers --}}
                <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-cyan-900 to-blue-600"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,rgba(103,232,249,0.2),transparent_45%),radial-gradient(circle_at_80%_70%,rgba(56,189,248,0.18),transparent_40%)]"></div>
                <div class="absolute inset-0 bg-slate-950/30"></div>


                {{-- Middle: Hero content --}}
                <div class="relative z-10 space-y-6">
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold leading-snug text-white xl:text-4xl">
                            Manajemen Pelanggan<br>WiFi
                        </h1>
                        <p class="max-w-sm text-sm leading-relaxed text-cyan-100">
                            Pantau pembayaran pelanggan dan kelola pengguna WiFi dalam satu dasbor sederhana.
                        </p>
                    </div>
                </div>

                {{-- Bottom: small note --}}
                <p class="absolute bottom-12 z-10 text-xs text-slate-400">
                    Sistem internal — hanya untuk personel berwenang.
                </p>
            </div>

            {{-- ===================== RIGHT: FORM ===================== --}}
            <div class="flex min-h-screen flex-col justify-center bg-slate-100 px-6 py-10 sm:px-10">

                {{-- Form card --}}
                <div class="mx-auto w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-200/70 sm:p-8">
                    <div class="mb-8 space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-widest text-cyan-700">Selamat Datang Kembali</p>
                        <h2 class="text-2xl font-bold text-slate-900">Masuk ke dasbor Anda</h2>
                        <p class="text-sm text-slate-500">Masuk untuk mengelola pelanggan dan memantau status pembayaran.</p>
                    </div>

                    {{-- Error alert --}}
                    @if ($errors->any())
                        <div class="mb-5 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Login identifier --}}
                        <div class="space-y-1.5">
                            <label for="login" class="text-sm font-medium text-slate-700">Email atau Nama Pengguna</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </span>
                                <input
                                    id="login"
                                    name="login"
                                    type="text"
                                    autocomplete="username"
                                    required
                                    value="{{ old('login') }}"
                                    placeholder="email atau nama pengguna"
                                    class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-cyan-500 focus:ring-3 focus:ring-cyan-100 @error('login') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                                >
                            </div>
                            @error('login')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="password" class="text-sm font-medium text-slate-700">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-cyan-700 hover:text-cyan-800 hover:underline">Lupa kata sandi?</a>
                                @else
                                    <a href="#" class="text-xs text-cyan-700 hover:text-cyan-800 hover:underline">Lupa kata sandi?</a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 1 0-8.25 0V10.5m-.75 0h9.75A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21h-9a2.25 2.25 0 0 1-2.25-2.25v-6A2.25 2.25 0 0 1 8.25 10.5Z" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    required
                                    placeholder="••••••••"
                                    class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-cyan-500 focus:ring-3 focus:ring-cyan-100 @error('password') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                                >
                            </div>
                            @error('password')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember me --}}
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-600">
                            <input
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            Ingat saya
                        </label>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-gradient-to-r from-cyan-600 to-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-cyan-900/20 transition hover:shadow-cyan-900/40 hover:brightness-105 active:brightness-95 focus:outline-none focus:ring-3 focus:ring-cyan-300"
                        >
                            Masuk
                        </button>
                    </form>
                </div>

                {{-- Footer note --}}
                <p class="mt-8 text-center text-xs text-slate-400">
                    Akses terbatas. Harap hubungi admin jika Anda tidak memiliki akun.
                </p>
            </div>
        </div>

    </body>
</html>
