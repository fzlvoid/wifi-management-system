<?php

use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\CacheController;
use Illuminate\Support\Facades\Route;

Route::get('/billing/generate', [BillingController::class, 'generate']);
Route::post('/billing/generate', [BillingController::class, 'generate']);

Route::get('/flush-cache', [CacheController::class, 'flush']);
Route::get('/health', [CacheController::class, 'health']);
