<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheController extends Controller
{
    private function authenticate(Request $request): ?User
    {
        $apiKey = $request->query('api_key') ?? $request->header('X-Api-Key');

        if (! $apiKey) {
            return null;
        }

        return User::where('role', 'admin')
            ->whereNotNull('api_key')
            ->where('api_key', $apiKey)
            ->first();
    }

    private function unauthorizedResponse(): JsonResponse
    {
        return response()->json(['error' => 'API key tidak valid atau tidak memiliki akses.'], 403);
    }

    public function flush(Request $request): JsonResponse
    {
        if (! $this->authenticate($request)) {
            return $this->unauthorizedResponse();
        }

        Cache::flush();

        return response()->json([
            'success' => true,
            'message' => 'Cache flushed successfully.',
        ]);
    }

    public function health(Request $request): JsonResponse
    {
        if (! $this->authenticate($request)) {
            return $this->unauthorizedResponse();
        }

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
