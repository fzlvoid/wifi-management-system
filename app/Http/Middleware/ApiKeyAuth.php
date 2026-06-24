<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->query('api_key') ?? $request->header('X-Api-Key');

        if (! $apiKey) {
            return response()->json(['error' => 'API key wajib disertakan.'], 401);
        }

        $admin = User::where('role', 'admin')
            ->whereNotNull('api_key')
            ->where('api_key', $apiKey)
            ->first();

        if (! $admin) {
            return response()->json(['error' => 'API key tidak valid atau tidak memiliki akses.'], 403);
        }

        $request->attributes->set('api_user', $admin);

        return $next($request);
    }
}
