<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kelola User — {{ config('app.name', 'WiFi Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
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
                    <h1 class="text-sm font-semibold text-slate-800 sm:text-base">Kelola User</h1>
                    <p class="hidden text-xs text-slate-400 sm:block">Super Admin Panel — Manajemen pengguna platform</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-cyan-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-cyan-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah User
                </a>
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

                {{-- Stats --}}
                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Total User Aktif</p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">{{ $users->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="rounded-xl border border-emerald-100 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Langganan Aktif</p>
                        <p class="mt-1 text-3xl font-bold text-emerald-600">
                            {{ $users->filter(fn($u) => $u->subscription_end && $u->subscription_end->gte(now()))->count() }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-red-100 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Langganan Expired</p>
                        <p class="mt-1 text-3xl font-bold text-red-500">
                            {{ $users->filter(fn($u) => !$u->subscription_end || $u->subscription_end->lt(now()))->count() }}
                        </p>
                    </div>
                </div>

                {{-- Users Table --}}
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-3">
                        <h2 class="font-semibold text-slate-800">Daftar Pengguna Platform</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="px-5 py-3">User</th>
                                    <th class="px-5 py-3">Username / Email</th>
                                    <th class="px-5 py-3">Langganan</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($users as $user)
                                    @php
                                        $subActive = $user->subscription_end && $user->subscription_end->gte(now());
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-cyan-100 text-xs font-bold text-cyan-700 uppercase">
                                                    {{ strtoupper(substr($user->name ?? $user->username, 0, 1)) }}
                                                </div>
                                                <p class="font-medium text-slate-800">{{ $user->name ?? $user->username }}</p>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <p class="text-slate-700">{{ $user->username }}</p>
                                            <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if($user->subscription_start && $user->subscription_end)
                                                <p class="text-xs text-slate-700">{{ $user->subscription_start->format('d M Y') }} –</p>
                                                <p class="text-xs font-medium {{ $subActive ? 'text-emerald-600' : 'text-red-500' }}">
                                                    {{ $user->subscription_end->format('d M Y') }}
                                                </p>
                                            @else
                                                <span class="text-xs text-slate-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if(!$user->is_active)
                                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">Nonaktif</span>
                                            @elseif($subActive)
                                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Aktif</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-600 ring-1 ring-red-200">Expired</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-1.5">
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                   class="rounded border border-cyan-200 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700 hover:bg-cyan-100 transition-colors">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus user {{ $user->name }}?')"
                                                            class="rounded border border-red-200 bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">Belum ada user. <a href="{{ route('admin.users.create') }}" class="text-cyan-600 hover:underline">Tambah sekarang</a></td>
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
