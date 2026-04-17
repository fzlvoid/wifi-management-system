<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $package ? 'Edit' : 'Tambah' }} Paket — {{ config('app.name', 'WiFi Manager') }}</title>
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
                        <span class="font-medium text-slate-800">{{ $package ? 'Edit' : 'Tambah' }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">

                <div class="mb-5">
                    <h1 class="text-lg font-semibold text-slate-900">
                        {{ $package ? 'Edit Paket' : 'Tambah Paket Baru' }}
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-500">
                        {{ $package ? "Perbarui detail untuk \"{$package->name}\"." : 'Daftarkan paket WiFi baru.' }}
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
                                <label for="name" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Nama Paket <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $package?->name) }}"
                                    placeholder="contoh: Paket Fastnet 50Mbps"
                                    class="w-full rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div>
                                <label for="price" class="mb-1.5 block text-xs font-medium text-slate-700">
                                    Harga / Bulan (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="price"
                                    type="number"
                                    name="price"
                                    value="{{ old('price', $package?->price) }}"
                                    placeholder="contoh: 300000"
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
                                    Deskripsi <span class="text-slate-400 font-normal">(opsional)</span>
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="contoh: Cocok untuk keluarga, termasuk dukungan streaming..."
                                    class="w-full resize-none rounded-lg border px-3 py-2 text-sm text-slate-800 outline-none transition
                                           {{ $errors->has('description') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100' }}"
                                >{{ old('description', $package?->description) }}</textarea>
                                @error('description')
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
                                {{ $package ? 'Perbarui Paket' : 'Simpan Paket' }}
                            </button>
                            <a href="{{ route('packages.index') }}"
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
