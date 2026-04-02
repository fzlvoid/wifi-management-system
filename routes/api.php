<?php

use App\Http\Controllers\Api\BillingController;
use Illuminate\Support\Facades\Route;

Route::get('/billing/generate', [BillingController::class, 'generate']);
Route::post('/billing/generate', [BillingController::class, 'generate']);
