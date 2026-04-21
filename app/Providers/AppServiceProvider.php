<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS outside local and add DB debugging helpers in local/dev
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        if (app()->environment('local') || env('APP_DEBUG', false)) {
            Model::preventLazyLoading(true);

            DB::listen(function ($query) {
                // Log slow queries (ms)
                $threshold = (int) env('DB_SLOW_QUERY_MS', 100);
                if ($query->time > $threshold) {
                    Log::warning('Slow query detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time_ms' => $query->time,
                    ]);
                }
            });
        }
    }
}
