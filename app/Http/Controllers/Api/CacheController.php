<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheController extends Controller
{
    public function flush(Request $request): JsonResponse
    {
        Cache::flush();

        return response()->json([
            'success' => true,
            'message' => 'Cache flushed successfully.',
        ]);
    }

    public function health(Request $request): JsonResponse
    {
        $dbStatus = 'ok';
        $cacheStatus = 'ok';

        try {
            DB::connection()->getPdo();
        } catch (\Throwable) {
            $dbStatus = 'error';
        }

        try {
            $testKey = 'health_check:'.time();
            Cache::put($testKey, 'ok', 30);
            $cacheStatus = Cache::get($testKey) === 'ok' ? 'ok' : 'error';
            Cache::forget($testKey);
        } catch (\Throwable) {
            $cacheStatus = 'error';
        }

        return response()->json([
            'status' => $dbStatus === 'ok' && $cacheStatus === 'ok' ? 'healthy' : 'unhealthy',
            'database' => $dbStatus,
            'cache' => $cacheStatus,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
