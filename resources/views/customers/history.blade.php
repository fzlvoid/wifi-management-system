<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Histori Tagihan {{ $customer->name }} — {{ config('app.name', 'WiFi Manager') }}</title>
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
                <span class="font-medium text-slate-800">Histori Tagihan</span>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6">
            <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">{{ $customer->name }}</h1>
                    <p class="mt-0.5 text-sm text-slate-500 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.273-3.973-6.869-6.869l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        <span class="truncate">{{ $customer->phone ?? 'Tidak ada nomor telepon' }}</span>
                        <span class="text-slate-300 hidden sm:inline">•</span>
                        <span class="truncate hidden sm:inline">{{ $customer->address ?? 'Tidak ada alamat' }}</span>
                    </p>
                    <p class="mt-0.5 text-sm text-slate-500 sm:hidden truncate">{{ $customer->address ?? 'Tidak ada alamat' }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center shrink-0 rounded-lg bg-white border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 shadow-sm transition-colors">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 px-5 py-4">
                    <h2 class="font-semibold text-slate-800">Riwayat Tagihan</h2>
                </div>

                {{-- Mobile List --}}
                <div class="divide-y divide-slate-100 sm:hidden">
                    @forelse($billings as $billing)
                        <div class="px-5 py-4">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-slate-800">Tagihan {{ \Carbon\Carbon::create()->month($billing->billing_month)->locale('id')->translatedFormat('F') }} {{ $billing->billing_year }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Rp {{ number_format($billing->amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="shrink-0 ml-3">
                                    @if($billing->status === 'paid')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-600/20 uppercase">Lunas</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-amber-700 ring-1 ring-inset ring-amber-600/20 uppercase">Belum Bayar</span>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="bg-slate-50 border border-slate-100 p-2.5 rounded-lg">
                                    <span class="block text-slate-400 mb-1">Jatuh Tempo</span>
                                    <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($billing->due_date)->format('d M Y') }}</span>
                                </div>
                                <div class="bg-slate-50 border border-slate-100 p-2.5 rounded-lg relative overflow-hidden">
                                    <span class="block text-slate-400 mb-1">Tanggal Bayar</span>
                                    <span class="font-semibold text-slate-700 relative z-10">{{ $billing->payment_date ? \Carbon\Carbon::parse($billing->payment_date)->format('d M Y H:i') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center text-sm text-slate-400">Belum ada riwayat tagihan.</div>
                    @endforelse
                </div>

                {{-- Desktop Table --}}
                <div class="hidden overflow-x-auto sm:block">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 border-b border-slate-100 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Periode</th>
                                <th class="px-5 py-3">Nominal</th>
                                <th class="px-5 py-3">Jatuh Tempo</th>
                                <th class="px-5 py-3">Tanggal Bayar</th>
                                <th class="px-5 py-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($billings as $billing)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ \Carbon\Carbon::create()->month($billing->billing_month)->locale('id')->translatedFormat('F') }} {{ $billing->billing_year }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-700">
                                    Rp {{ number_format($billing->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ \Carbon\Carbon::parse($billing->due_date)->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $billing->payment_date ? \Carbon\Carbon::parse($billing->payment_date)->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-5 py-4 text-right">
                                    @if($billing->status === 'paid')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-emerald-700 border border-emerald-200 uppercase">Lunas</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold tracking-wide text-amber-700 border border-amber-200 uppercase">Belum Bayar</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">Belum ada riwayat tagihan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($billings->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $billings->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
