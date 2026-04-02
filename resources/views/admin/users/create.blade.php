<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ isset($user) ? 'Edit User' : 'Tambah User' }} — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <input type="checkbox" id="nav-open" class="peer/nav sr-only">

        <aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-slate-900 text-white
                      -translate-x-full transition-transform duration-200
                      peer-checked/nav:translate-x-0 lg:translate-x-0">
            <div class="flex h-16 shrink-0 items-center justify-between px-5 border-b border-slate-700/60">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 text-white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold">{{ config('app.name') }}</span>
                </div>
                <label for="nav-open" class="cursor-pointer rounded-md p-1 text-slate-400 hover:text-white lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </label>
            </div>
            <nav class="flex-1 px-3 py-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-lg bg-cyan-600/20 px-3 py-2.5 text-sm font-medium text-cyan-300">Kelola User</a>
            </nav>
            <div class="shrink-0 border-t border-slate-700/60 px-4 py-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-slate-400 hover:text-white transition-colors">Logout</button>
                </form>
            </div>
        </aside>

        <label for="nav-open" class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden"></label>

        <div class="flex min-h-screen flex-col lg:pl-64">
            <header class="sticky top-0 z-20 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
                <label for="nav-open" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>
                <div class="flex items-center gap-1.5 text-sm text-slate-500">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-slate-800 transition-colors">Kelola User</a>
                    <span>/</span>
                    <span class="font-medium text-slate-800">{{ isset($user) ? 'Edit' : 'Tambah' }}</span>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                <div class="mb-5">
                    <h1 class="text-lg font-semibold text-slate-900">{{ isset($user) ? 'Edit User: '.$user->name : 'Tambah User Baru' }}</h1>
                    <p class="mt-0.5 text-sm text-slate-500">
                        {{ isset($user) ? 'Perbarui data user dan masa langganan.' : 'Daftarkan pemilik RT-RW Net baru ke platform.' }}
                    </p>
                </div>

                @if($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                        <ul class="space-y-1 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <form method="POST"
                          action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}"
                          novalidate>
                        @csrf
                        @if(isset($user)) @method('PUT') @endif

                        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="name" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                       placeholder="e.g. Budi Santoso"
                                       class="w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                                              {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Username --}}
                            <div>
                                <label for="username" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input id="username" type="text" name="username" value="{{ old('username', $user->username ?? '') }}"
                                       placeholder="e.g. budi123"
                                       class="w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                                              {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                @error('username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                       placeholder="e.g. budi@example.com"
                                       class="w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                                              {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="password" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
                                    @if(!isset($user)) <span class="text-red-500">*</span> @endif
                                </label>
                                <input id="password" type="password" name="password"
                                       placeholder="{{ isset($user) ? '••••••••' : 'Min. 8 karakter' }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                                              {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Subscription Start --}}
                            <div>
                                <label for="subscription_start" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Mulai Langganan <span class="text-red-500">*</span>
                                </label>
                                <input id="subscription_start" type="date" name="subscription_start"
                                       value="{{ old('subscription_start', isset($user) ? optional($user->subscription_start)->format('Y-m-d') : '') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                                              {{ $errors->has('subscription_start') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                @error('subscription_start') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Subscription End --}}
                            <div>
                                <label for="subscription_end" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Akhir Langganan <span class="text-red-500">*</span>
                                </label>
                                <input id="subscription_end" type="date" name="subscription_end"
                                       value="{{ old('subscription_end', isset($user) ? optional($user->subscription_end)->format('Y-m-d') : '') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                                              {{ $errors->has('subscription_end') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}">
                                @error('subscription_end') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Status Aktif --}}
                            <div class="sm:col-span-2">
                                <label class="mb-1.5 block text-xs font-medium text-slate-700">Status Akun</label>
                                <label class="inline-flex cursor-pointer items-center gap-2">
                                    <input type="hidden" name="is_active" value="0">
                                    <input id="is_active" type="checkbox" name="is_active" value="1"
                                           {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                                    <span class="text-sm text-slate-700">Aktifkan akun ini</span>
                                </label>
                            </div>

                            {{-- API Key (readonly, hanya tampil saat edit) --}}
                            @if(isset($user) && $user->api_key)
                            <div class="sm:col-span-2">
                                <label class="mb-1.5 block text-xs font-medium text-slate-700">API Key (untuk Cron Job)</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" value="{{ $user->api_key }}" readonly
                                           class="flex-1 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 font-mono text-xs text-slate-600">
                                    <form method="POST" action="{{ route('admin.users.regenerate-api-key', $user) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Regenerate API Key? Cron job lama akan berhenti berfungsi.')"
                                                class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700 hover:bg-amber-100 transition-colors">
                                            Regenerate
                                        </button>
                                    </form>
                                </div>
                                <p class="mt-1 text-xs text-slate-400">Gunakan key ini di cron job cPanel: <code class="font-mono">GET /api/billing/generate?api_key=KEY</code></p>
                            </div>
                            @endif

                        </div>

                        <div class="mt-7 flex items-center gap-3 border-t border-slate-100 pt-5">
                            <button type="submit"
                                    class="rounded-lg bg-cyan-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                                {{ isset($user) ? 'Simpan Perubahan' : 'Tambah User' }}
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                               class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>
