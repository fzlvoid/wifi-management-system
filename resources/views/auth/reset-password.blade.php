<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'WiFi Manager') }} — Reset Password</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

        <div class="flex min-h-screen flex-col items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/70">

                <div class="mb-6 space-y-1">
                    <h2 class="text-2xl font-bold text-slate-900">Reset password</h2>
                    <p class="text-sm text-slate-500">Choose a new password for your account.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="space-y-1.5">
                        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email', $request->email) }}"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-cyan-500 focus:ring-3 focus:ring-cyan-100 @error('email') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        >
                        @error('email')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="text-sm font-medium text-slate-700">New Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-3 focus:ring-cyan-100 @error('password') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                        >
                        @error('password')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-sm font-medium text-slate-700">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-cyan-500 focus:ring-3 focus:ring-cyan-100"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-cyan-600 to-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:brightness-105 focus:outline-none focus:ring-3 focus:ring-cyan-300"
                    >
                        Reset Password
                    </button>
                </form>

            </div>
        </div>

    </body>
</html>
