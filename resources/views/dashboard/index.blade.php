<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
        <input type="checkbox" id="nav-open" class="peer/nav sr-only">
        <x-sidebar />
        <label for="nav-open" class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden"></label>

        <div class="flex min-h-screen flex-col lg:pl-64">
            <header class="sticky top-0 z-20 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
                <label for="nav-open" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>
                <div class="flex-1">
                    <h1 class="text-sm font-semibold text-slate-800 sm:text-base">Dashboard</h1>
                    <p class="hidden text-xs text-slate-400 sm:block">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
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

                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Total Pelanggan Aktif</p>
                                <p class="mt-1 text-3xl font-bold text-slate-900">{{ $summary['totalActiveCustomers'] }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-100 p-2 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-cyan-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Pendapatan Bulan Ini</p>
                                <p class="mt-1 text-2xl font-bold text-cyan-700">Rp {{ number_format($summary['currentMonthRevenue'], 0, ',', '.') }}</p>
                                <p class="mt-1 text-[10px] text-slate-400">{{ now()->locale('id')->translatedFormat('F Y') }}</p>
                            </div>
                            <div class="rounded-lg bg-cyan-50 p-2 text-cyan-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-amber-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Total Piutang</p>
                                <p class="mt-1 text-2xl font-bold text-amber-500">Rp {{ number_format($summary['totalReceivables'], 0, ',', '.') }}</p>
                                <p class="mt-1 text-[10px] text-slate-400">Total tagihan tertunggak</p>
                            </div>
                            <div class="rounded-lg bg-amber-50 p-2 text-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-red-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-slate-500">Belum Lunas & Menunggak</p>
                                <p class="mt-1 text-3xl font-bold text-red-600">{{ $summary['unpaidBillsCount'] }}</p>
                                <p class="mt-1 text-[10px] text-slate-400">Tunggakan tagihan</p>
                            </div>
                            <div class="rounded-lg bg-red-50 p-2 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2.25m0 4.5h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-slate-800 mb-4">Grafik Pertumbuhan Pendapatan (Tahunan)</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="border-b border-slate-100 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h2 class="font-semibold text-slate-800">Daftar Pelanggan Aktif</h2>
                            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm w-full sm:w-48 focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                    <div class="flex gap-2">
                                        <select name="status" class="flex-1 sm:flex-none rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500" onchange="this.form.submit()">
                                            <option value="">Semua Status</option>
                                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="due_soon" {{ request('status') === 'due_soon' ? 'selected' : '' }}>H-7 Jatuh Tempo</option>
                                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Menunggak</option>
                                        </select>
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-100 px-3 py-1.5 text-slate-600 hover:bg-slate-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-cyan-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-cyan-700 transition-colors shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Tambah
                                </a>
                            </div>
                        </div>

                        {{-- MOBILE: Card list --}}
                        <div class="md:hidden divide-y divide-slate-100">
                            @forelse($customerList as $customer)
                            @php
                                $sub       = $customer->subscriptions->first();
                                $billing   = $customer->billings->first();
                                $subStatus = $sub ? $sub->status : 'inactive';
                                $statusMap = [
                                    'active'    => ['label' => 'Aktif',       'class' => 'bg-emerald-100 text-emerald-700'],
                                    'due_soon'  => ['label' => 'H-7 Jatuh Tempo', 'class' => 'bg-amber-100 text-amber-700'],
                                    'overdue'   => ['label' => 'Menunggak',   'class' => 'bg-red-100 text-red-600'],
                                    'inactive'  => ['label' => 'Tidak Aktif', 'class' => 'bg-slate-100 text-slate-500'],
                                ];
                                $status = $statusMap[$subStatus];

                                $waLink = null;
                                if (in_array($subStatus, ['due_soon', 'overdue'])) {
                                    $adminName = auth()->user()->username ?? 'Admin';
                                    $rawPhone = preg_replace('/\D+/', '', (string) $customer->phone);
                                    $waPhone  = str_starts_with($rawPhone, '0') ? '62'.substr($rawPhone, 1) : $rawPhone;
                                    if ($waPhone !== '' && ! str_starts_with($waPhone, '62')) { $waPhone = '62'.$waPhone; }

                                    $refDate = $sub?->end_date ? \Carbon\Carbon::parse($sub->end_date) : now();
                                    $dueMonth   = $refDate->copy()->addMonth()->locale('id')->translatedFormat('F');
                                    $dueDateStr = $refDate->locale('id')->translatedFormat('d M Y');
                                    $priceStr   = number_format(($billing ? $billing->amount : ($sub?->package?->price ?? 0)), 0, ',', '.');

                                    if ($subStatus === 'due_soon') {
                                        $msg = "Pelanggan Yth. {$customer->name}\n\nKami menginformasikan bahwa tagihan internet Anda untuk periode {$dueMonth} sebesar Rp. {$priceStr} telah terbit dan akan jatuh tempo pada {$dueDateStr}.\n\nMohon berkenan untuk melakukan pembayaran sebelum tanggal jatuh tempo agar layanan internet Anda tidak terganggu.\n\nAbaikan pesan ini jika Anda sudah melakukan pembayaran.\n\nSalam,\n{$adminName}";
                                    } else {
                                        $msg = "Pelanggan Yth. {$customer->name}\n\nKami belum menerima pembayaran Anda untuk periode {$dueMonth} sebesar Rp. {$priceStr}. Mohon segera melakukan pembayaran.\n\nApabila Anda berhenti berlangganan maka akan dikenakan biaya tambahan berupa penalty sebesar Rp. 1.000.000 dan biaya penarikan perangkat Rp. 100.000.\n\nSelanjutnya Tim {$adminName} akan menyerahkan proses penagihan kepada Petugas Collection lapangan {$adminName}\n\nAbaikan jika Anda sudah melakukan pembayaran\n\nSalam,\n{$adminName}";
                                    }
                                    $waLink = $waPhone !== '' ? 'https://wa.me/'.$waPhone.'?text='.rawurlencode($msg) : null;
                                }
                            @endphp
                            <div class="px-4 py-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-cyan-100 text-sm font-bold text-cyan-700">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-800 text-sm">{{ $customer->name }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $customer->phone ?? '—' }}</p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </div>
                                <div class="mt-3 grid grid-cols-2 gap-x-4 gap-y-2 text-xs">
                                    <div>
                                        <p class="font-semibold uppercase tracking-wide text-[10px] text-slate-400">Paket</p>
                                        <p class="mt-0.5 text-slate-700">{{ $sub?->package?->name ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold uppercase tracking-wide text-[10px] text-slate-400">Jatuh Tempo</p>
                                        <p class="mt-0.5 text-slate-700">{{ $sub?->end_date ? \Carbon\Carbon::parse($sub->end_date)->locale('id')->translatedFormat('d M Y') : '—' }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="font-semibold uppercase tracking-wide text-[10px] text-slate-400">Alamat</p>
                                        <p class="mt-0.5 text-slate-700">{{ $customer->address ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @if($billing && $billing->status !== 'paid')
                                        <form method="POST" action="{{ route('dashboard.pay', $billing->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition-colors">Tandai Lunas</button>
                                        </form>
                                    @elseif($billing && $billing->status === 'paid')
                                        <form method="POST" action="{{ route('dashboard.reversal', $billing->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Yakin ingin batalkan pembayaran?')" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">Batal Lunas</button>
                                        </form>
                                    @endif
                                    @if($waLink)
                                        <a href="{{ $waLink }}" target="_blank" class="rounded-lg border border-green-200 bg-white px-3 py-1.5 text-xs font-semibold text-green-600 hover:bg-green-50 transition-colors">Chat WA</a>
                                    @endif
                                    <a href="{{ route('customers.history', $customer->id) }}" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Histori</a>
                                </div>
                            </div>
                            @empty
                            <div class="px-5 py-8 text-center text-sm text-slate-400">Belum ada pelanggan aktif.</div>
                            @endforelse
                        </div>

                        {{-- DESKTOP: Table --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                        <th class="px-5 py-3">Pelanggan</th>
                                        <th class="px-5 py-3">Alamat</th>
                                        <th class="px-5 py-3">Paket</th>
                                        <th class="px-5 py-3">Jatuh Tempo</th>
                                        <th class="px-5 py-3">Status Langganan</th>
                                        <th class="px-5 py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($customerList as $customer)
                                    @php
                                        $sub       = $customer->subscriptions->first();
                                        $billing   = $customer->billings->first();
                                        $subStatus = $sub ? $sub->status : 'inactive';
                                        $statusMap = [
                                            'active'    => ['label' => 'Aktif',       'class' => 'bg-emerald-100 text-emerald-700'],
                                            'due_soon'  => ['label' => 'H-7 Jatuh Tempo', 'class' => 'bg-amber-100 text-amber-700'],
                                            'overdue'   => ['label' => 'Menunggak',   'class' => 'bg-red-100 text-red-600'],
                                            'inactive'  => ['label' => 'Tidak Aktif', 'class' => 'bg-slate-100 text-slate-500'],
                                        ];
                                        $status = $statusMap[$subStatus];

                                        $waLink = null;
                                        if (in_array($subStatus, ['due_soon', 'overdue'])) {
                                            $adminName = auth()->user()->username ?? 'Admin';
                                            $rawPhone = preg_replace('/\D+/', '', (string) $customer->phone);
                                            $waPhone  = str_starts_with($rawPhone, '0') ? '62'.substr($rawPhone, 1) : $rawPhone;
                                            if ($waPhone !== '' && ! str_starts_with($waPhone, '62')) { $waPhone = '62'.$waPhone; }

                                            $refDate = $sub?->end_date ? \Carbon\Carbon::parse($sub->end_date) : now();
                                            $dueMonth   = $refDate->copy()->addMonth()->locale('id')->translatedFormat('F');
                                            $dueDateStr = $refDate->locale('id')->translatedFormat('d M Y');
                                            $priceStr   = number_format(($billing ? $billing->amount : ($sub?->package?->price ?? 0)), 0, ',', '.');

                                            if ($subStatus === 'due_soon') {
                                                $msg = "Pelanggan Yth. {$customer->name}\n\nKami menginformasikan bahwa tagihan internet Anda untuk periode {$dueMonth} sebesar Rp. {$priceStr} telah terbit dan akan jatuh tempo pada {$dueDateStr}.\n\nMohon berkenan untuk melakukan pembayaran sebelum tanggal jatuh tempo agar layanan internet Anda tidak terganggu.\n\nAbaikan pesan ini jika Anda sudah melakukan pembayaran.\n\nSalam,\n{$adminName}";
                                            } else {
                                                $msg = "Pelanggan Yth. {$customer->name}\n\nKami belum menerima pembayaran Anda untuk periode {$dueMonth} sebesar Rp. {$priceStr}. Mohon segera melakukan pembayaran.\n\nApabila Anda berhenti berlangganan maka akan dikenakan biaya tambahan berupa penalty sebesar Rp. 1.000.000 dan biaya penarikan perangkat Rp. 100.000.\n\nSelanjutnya Tim {$adminName} akan menyerahkan proses penagihan kepada Petugas Collection lapangan {$adminName}\n\nAbaikan jika Anda sudah melakukan pembayaran\n\nSalam,\n{$adminName}";
                                            }
                                            $waLink = $waPhone !== '' ? 'https://wa.me/'.$waPhone.'?text='.rawurlencode($msg) : null;
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-5 py-3">
                                            <p class="font-medium text-slate-800">{{ $customer->name }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $customer->phone ?? '—' }}</p>
                                        </td>
                                        <td class="px-5 py-3 text-slate-600 text-xs">{{ $customer->address ?? '—' }}</td>
                                        <td class="px-5 py-3 text-slate-600">{{ $sub?->package?->name ?? '—' }}</td>
                                        <td class="px-5 py-3 text-slate-600">{{ $sub?->end_date ? \Carbon\Carbon::parse($sub->end_date)->locale('id')->translatedFormat('d M Y') : '—' }}</td>
                                        <td class="px-5 py-3">
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $status['class'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right whitespace-nowrap">
                                            @if($billing && $billing->status !== 'paid')
                                                <form method="POST" action="{{ route('dashboard.pay', $billing->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 underline">Tandai Lunas</button>
                                                </form>
                                            @elseif($billing && $billing->status === 'paid')
                                                <form method="POST" action="{{ route('dashboard.reversal', $billing->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Yakin ingin batalkan pembayaran?')" class="text-xs font-semibold text-red-500 hover:text-red-600 underline">Batal Lunas</button>
                                                </form>
                                            @endif
                                            @if($waLink)
                                                <span class="text-slate-300 mx-1">|</span>
                                                <a href="{{ $waLink }}" target="_blank" class="text-xs font-semibold text-green-600 hover:text-green-700 underline">Chat WA</a>
                                            @endif
                                            <span class="text-slate-300 mx-1">|</span>
                                            <a href="{{ route('customers.history', $customer->id) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 underline">Histori</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada pelanggan aktif.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($customerList->hasPages())
                        <div class="border-t border-slate-100 px-5 py-4">
                            {{ $customerList->withQueryString()->links() }}
                        </div>
                        @endif
                    </div>

                    {{-- OVERDUE WIDGET --}}
                    <div class="rounded-xl border border-red-100 bg-white p-5 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="font-semibold text-slate-800">5 Tagihan Menunggak Teratas</h3>
                            <span class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-semibold text-red-600 uppercase tracking-widest">
                                Menunggak
                            </span>
                        </div>
                        
                        @if($overdueCustomers->isEmpty())
                            <div class="py-6 text-center text-sm text-slate-400">
                                Hebat, tidak ada tagihan menunggak! 🎉
                            </div>
                        @else
                            <ul class="space-y-3">
                                @foreach($overdueCustomers as $customer)
                                    @php 
                                        $oldestUnpaid = $customer->billings->first(); 
                                        $activeSub = $customer->subscriptions->first();
                                        $adminName = auth()->user()->username ?? 'Admin';

                                        $rawPhone = preg_replace('/\D+/', '', (string) $customer->phone);
                                        $waPhone  = str_starts_with($rawPhone, '0') ? '62'.substr($rawPhone, 1) : $rawPhone;
                                        if ($waPhone !== '' && ! str_starts_with($waPhone, '62')) { $waPhone = '62'.$waPhone; }

                                        $refDate = $activeSub?->end_date ? \Carbon\Carbon::parse($activeSub->end_date) : \Carbon\Carbon::parse($oldestUnpaid->due_date);
                                        
                                        $dueMonth = $refDate->copy()->addMonth()->locale('id')->translatedFormat('F');
                                        $dueDateStr = $refDate->locale('id')->translatedFormat('d M Y');
                                        $priceStr = number_format($oldestUnpaid->amount, 0, ',', '.');
                                        
                                        $billingMsg = "Pelanggan Yth. {$customer->name}\n\nKami belum menerima pembayaran Anda untuk periode {$dueMonth} sebesar Rp. {$priceStr}. Mohon segera melakukan pembayaran.\n\nApabila Anda berhenti berlangganan maka akan dikenakan biaya tambahan berupa penalty sebesar Rp. 1.000.000 dan biaya penarikan perangkat Rp. 100.000.\n\nSelanjutnya Tim {$adminName} akan menyerahkan proses penagihan kepada Petugas Collection lapangan {$adminName}\n\nAbaikan jika Anda sudah melakukan pembayaran\n\nSalam,\n{$adminName}";
                                        $waLink = $waPhone !== '' ? 'https://wa.me/'.$waPhone.'?text='.rawurlencode($billingMsg) : null;
                                    @endphp
                                    <li class="flex items-start gap-3 rounded-lg border border-red-100 bg-red-50 p-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-200 text-xs font-bold text-red-700">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-slate-800">{{ $customer->name }}</p>
                                            <p class="text-[11px] text-red-600 font-medium">Rp {{ $priceStr }}</p>
                                            <p class="mt-0.5 text-[10px] text-slate-500">
                                                Jatuh tempo: {{ \Carbon\Carbon::parse($oldestUnpaid->due_date)->locale('id')->translatedFormat('d M Y') }}
                                            </p>
                                            @php $activeSub = $customer->subscriptions->first(); @endphp
                                            @if($activeSub)
                                            <p class="mt-0.5 text-[10px] text-slate-500">
                                                Paket: <span class="font-medium text-slate-700">{{ $activeSub->package?->name ?? '—' }}</span>
                                                &bull; Tgl tagihan tiap bln: <span class="font-medium text-slate-700">{{ $activeSub->billing_cycle_date }}</span>
                                            </p>
                                            @endif
                                            <div class="mt-2 text-xs flex gap-2">
                                                <form method="POST" action="{{ route('dashboard.pay', $oldestUnpaid->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="font-medium text-emerald-600 hover:text-emerald-700 underline">Tandai Lunas</button>
                                                </form>
                                                @if($waLink)
                                                    <span class="text-slate-300">|</span>
                                                    <a href="{{ $waLink }}" target="_blank" class="font-medium text-green-600 hover:text-green-700 border-b border-transparent hover:border-green-600 transition-colors">Chat WA</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </main>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                
                const labels = {!! json_encode($chartData['labels']) !!};
                const data = {!! json_encode($chartData['data']) !!};

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: data,
                            borderColor: '#0284c7', // cyan-600
                            backgroundColor: 'rgba(2, 132, 199, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#0284c7',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw || 0;
                                        return ' Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    }
                                }
                            } // no trailing comma before bracket end logic
                        }
                    }
                });
            });
        </script>
    </body>
</html>
