<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/pay/{id}', [DashboardController::class, 'markAsPaid'])->name('dashboard.pay');
    Route::post('/dashboard/reversal/{id}', [DashboardController::class, 'reversal'])->name('dashboard.reversal');

    // Packages
    Route::resource('packages', PackageController::class)->except(['show']);

    // Customers
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::get('/deactivated', [CustomerController::class, 'deactivated'])->name('deactivated');
        Route::get('/hapus', [CustomerController::class, 'deleteList'])->name('delete_list');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::patch('/{id}/activate', [CustomerController::class, 'activate'])->name('activate');
        Route::patch('/{id}/deactivate', [CustomerController::class, 'deactivate'])->name('deactivate');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Super Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class);
        Route::post('/users/{user}/regenerate-api-key', [AdminUserController::class, 'regenerateApiKey'])
            ->name('users.regenerate-api-key');
    });
});
