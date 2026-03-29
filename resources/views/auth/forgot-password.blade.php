<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'WiFi Manager') }} — Forgot Password</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <div class="flex min-h-screen flex-col items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/70">

                <div class="mb-6 space-y-1">
                    <h2 class="text-2xl font-bold text-slate-900">Forgot password?</h2>
                    <p class="text-sm text-slate-500">Enter your email and we'll send you a reset link.</p>
                </div>

                @if (session('status'))
                    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            placeholder="admin@example.com"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-cyan-500 focus:ring-3 focus:ring-cyan-100 @error('email') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        >
                        @error('email')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-cyan-600 to-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:brightness-105 focus:outline-none focus:ring-3 focus:ring-cyan-300"
                    >
                        Send Reset Link
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    <a href="{{ route('login') }}" class="font-medium text-cyan-600 hover:underline">← Back to login</a>
                </p>

            </div>
        </div>

    </body>
</html>
