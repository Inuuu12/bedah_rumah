<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Cegah Vite hot reload mengarah ke localhost jika diakses dari domain server/staging/production
        if (! $this->app->runningInConsole()) {
            $host = request()->getHost();
            if (! in_array($host, ['localhost', '127.0.0.1']) && file_exists(public_path('hot'))) {
                @unlink(public_path('hot'));
            }
        }
    }
}
