<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pelanggan Nonaktif — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <input type="checkbox" id="nav-open" class="peer/nav sr-only">

        <x-sidebar />

        <label for="nav-open" class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden"></label>

        <div class="flex min-h-screen flex-col lg:pl-64">

            <header class="sticky top-0 z-20 flex h-14 items-center gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
                <label for="nav-open" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>
                <div class="flex items-center gap-1.5 text-sm text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Dashboard</a>
                    <span>/</span>
                    <span>Pelanggan</span>
                    <span>/</span>
                    <span class="font-medium text-slate-800">Nonaktif</span>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">

                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold text-slate-900">Pelanggan Nonaktif</h1>
                        <p class="mt-0.5 text-sm text-slate-500">Daftar pelanggan yang saat ini statusnya tidak aktif.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    {{-- Mobile List --}}
                    <div class="divide-y divide-slate-100 sm:hidden">
                        @forelse($customers as $customer)
                            @php $payment = $customer->latestPayment; @endphp
                            <div class="px-4 py-3">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $customer->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $customer->address }}</p>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('customers.activate', $customer->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 transition hover:bg-emerald-100">
                                                Aktifkan
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus permanen pelanggan ini?')" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                                    <div>
                                        <p class="text-slate-400">Paket</p>
                                        <p class="font-medium text-slate-700">{{ $customer->package->package_name ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-400">Terakhir Lunas</p>
                                        <p class="font-medium text-slate-700">{{ $payment ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-8 text-center text-sm text-slate-400">Tidak ada pelanggan nonaktif.</div>
                        @endforelse
                    </div>

                    {{-- Desktop Table --}}
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="px-5 py-3">Pelanggan</th>
                                    <th class="px-5 py-3">Paket WiFi</th>
                                    <th class="px-5 py-3">Terakhir Lunas</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($customers as $customer)
                                    @php $payment = $customer->latestPayment; @endphp
                                    <tr class="opacity-60 hover:bg-slate-50/70 hover:opacity-100 transition-all">
                                        <td class="px-5 py-3.5">
                                            <p class="font-medium text-slate-800">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-400">{{ $customer->address }}</p>
                                        </td>
                                        <td class="px-5 py-3.5 text-slate-600">{{ $customer->package->package_name ?? '—' }}</td>
                                        <td class="px-5 py-3.5 text-slate-600">{{ $payment ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-1.5">
                                                <form method="POST" action="{{ route('customers.activate', $customer->id) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="rounded border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 transition hover:bg-emerald-100">
                                                        Aktifkan
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus permanen pelanggan ini?')" class="rounded border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada pelanggan nonaktif.</td>
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
