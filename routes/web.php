<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;

Route::get('/', fn () => redirect()->route('login'));

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/pay/{id}', [DashboardController::class, 'markAsPaid'])->name('dashboard.pay');

    Route::resource('packages', PackageController::class)->except(['show']);

    Route::prefix('customers')->name('users.')->group(function () {
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::get('/deactivated', [CustomerController::class, 'deactivated'])->name('deactivated');
        Route::post('/', [CustomerController::class, 'store'])->name('store');

        Route::patch('/{customer}/activate', [CustomerController::class, 'activate'])->name('activate');
        Route::patch('/{customer}/deactivate', [CustomerController::class, 'deactivate'])->name('deactivate');
    });
});
