<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Deactivated Users — {{ config('app.name', 'WiFi Manager') }}</title>
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
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Users group --}}
                <div>
                    <p class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4.5 w-4.5 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        Users
                    </p>
                    <div class="ml-3 mt-0.5 border-l border-slate-700 pl-4 space-y-0.5">
                        <a href="{{ route('users.create') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add User
                        </a>
                        <a href="{{ route('users.deactivated') }}"
                           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium bg-slate-800 text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-3.5 w-3.5 shrink-0" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Deactivated
                            @if ($users->count() > 0)
                                <span class="ml-auto rounded-full bg-slate-700 px-1.5 py-0.5 text-xs text-slate-300">{{ $users->count() }}</span>
                            @endif
                        </a>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    Payments
                </a>

                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Reports
                </a>

                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Settings
                </a>
            </nav>

            <div class="border-t border-slate-700/60 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-700 text-xs font-semibold text-white">
                            {{ strtoupper(substr(session('user', 'A'), 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-medium text-white">{{ session('user', 'admin') }}</p>
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

        <label for="nav-open"
               class="fixed inset-0 z-30 cursor-pointer bg-black/50 hidden peer-checked/nav:block lg:hidden">
        </label>

        <div class="flex min-h-screen flex-col lg:pl-64">

            <header class="sticky top-0 z-20 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
                <label for="nav-open" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>
                <div class="flex items-center gap-1.5 text-sm text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Dashboard</a>
                    <span>/</span>
                    <span>Users</span>
                    <span>/</span>
                    <span class="font-medium text-slate-800">Deactivated</span>
                </div>
                <div class="ml-auto hidden items-center gap-3 sm:flex">
                    <span class="text-xs text-slate-500">Logged in as <strong class="text-slate-700">{{ auth()->user()->username }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-slate-400 hover:text-slate-800">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">

                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold text-slate-900">Manage Users</h1>
                        <p class="mt-0.5 text-sm text-slate-500">Manage subscription status for all customers.</p>
                    </div>
                    <a href="{{ route('dashboard') }}"
                       class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                        ← Back to Dashboard
                    </a>
                </div>

                {{-- Flash message --}}
                @if (session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4 shrink-0" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    {{-- Mobile: card list --}}
                    <div class="divide-y divide-slate-100 sm:hidden">
                        @foreach ($users as $user)
                            <div class="px-4 py-3">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $user['name'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $user['unit'] }}</p>
                                        @if ($user['subscription'] === 'ACTIVE')
                                            <span class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-emerald-600">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        @else
                                            <span class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-slate-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Inactive
                                            </span>
                                        @endif
                                    </div>
                                    @if ($user['subscription'] === 'ACTIVE')
                                        <form method="POST" action="{{ route('users.deactivate', $user['id']) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="rounded-lg border border-orange-300 bg-orange-50 px-3 py-1.5 text-xs font-medium text-orange-700 transition hover:bg-orange-100">
                                                Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('users.activate', $user['id']) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 transition hover:bg-emerald-100">
                                                Activate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                                    <div>
                                        <p class="text-slate-400">Package</p>
                                        <p class="font-medium text-slate-700">{{ $user['package'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-400">Last Paid</p>
                                        <p class="font-medium text-slate-700">{{ $user['last_paid'] ? \Carbon\Carbon::parse($user['last_paid'])->format('M j, Y') : '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop: table --}}
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="px-5 py-3">User</th>
                                    <th class="px-5 py-3">WiFi Package</th>
                                    <th class="px-5 py-3">Last Paid</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-slate-50/70 transition-colors {{ $user['subscription'] === 'INACTIVE' ? 'opacity-60' : '' }}">
                                        <td class="px-5 py-3.5">
                                            <p class="font-medium text-slate-800">{{ $user['name'] }}</p>
                                            <p class="text-xs text-slate-400">{{ $user['unit'] }}</p>
                                        </td>
                                        <td class="px-5 py-3.5 text-slate-600">{{ $user['package'] }}</td>
                                        <td class="px-5 py-3.5 text-slate-600">{{ $user['last_paid'] ? \Carbon\Carbon::parse($user['last_paid'])->format('M j, Y') : '—' }}</td>
                                        <td class="px-5 py-3.5">
                                            @if ($user['subscription'] === 'ACTIVE')
                                                <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if ($user['subscription'] === 'ACTIVE')
                                                <form method="POST" action="{{ route('users.deactivate', $user['id']) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="rounded border border-orange-300 bg-orange-50 px-3 py-1.5 text-xs font-medium text-orange-700 transition hover:bg-orange-100">
                                                        Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('users.activate', $user['id']) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="rounded border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 transition hover:bg-emerald-100">
                                                        Activate
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </main>
        </div>

    </body>
</html>
