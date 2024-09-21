<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ConfigService;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('configService', function ($app) {
            return new ConfigService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
