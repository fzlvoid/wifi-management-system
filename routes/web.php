<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/', fn () => redirect()->route('login'));

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/pay/{id}', [DashboardController::class, 'markAsPaid'])->name('dashboard.pay');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/deactivated', [UserController::class, 'deactivated'])->name('deactivated');
        Route::post('/', [UserController::class, 'store'])->name('store');

        Route::patch('/{user}/activate', [UserController::class, 'activate'])->name('activate');
        Route::patch('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
    });
});
