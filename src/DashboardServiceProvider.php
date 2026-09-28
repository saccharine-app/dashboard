<?php

namespace Saccharine\Dashboard;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load views for the demo route
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'saccharine-dashboard');

        // Publish compiled assets to host's public directory
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../dist' => public_path('vendor/saccharine-dashboard'),
            ], 'saccharine-dashboard-assets');
        }

        // Optional: Register standalone demo route
        /* if (config('app.env') !== 'production') {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        } */
    }
}