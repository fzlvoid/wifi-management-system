<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', 'user')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', Password::min(8)],
            'subscription_start' => ['required', 'date'],
            'subscription_end' => ['required', 'date', 'after_or_equal:subscription_start'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['role'] = 'user';
        $validated['is_active'] = $request->boolean('is_active', true) ? DB::raw('TRUE') : DB::raw('FALSE');
        $validated['api_key'] = User::generateApiKey();

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', "unique:users,username,{$user->id}"],
            'email' => ['required', 'email', 'max:150', "unique:users,email,{$user->id}"],
            'password' => ['nullable', Password::min(8)],
            'subscription_start' => ['required', 'date'],
            'subscription_end' => ['required', 'date', 'after_or_equal:subscription_start'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true) ? DB::raw('TRUE') : DB::raw('FALSE');

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$user->name}\" berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$name}\" berhasil dihapus.");
    }

    public function regenerateApiKey(User $user): RedirectResponse
    {
        $user->update(['api_key' => User::generateApiKey()]);

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'API Key berhasil di-regenerate.');
    }
}
