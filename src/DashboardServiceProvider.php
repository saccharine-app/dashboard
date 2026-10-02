<?php

namespace Saccharine\Dashboard;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;

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

        // Register assets and page only if Filament is installed
        if (class_exists(\Filament\FilamentManager::class)) {
            $this->registerFilamentIntegration();
        }
    }

    protected function registerFilamentIntegration(): void
    {
        // Inject Vue styles & JS bundle exclusively on the dashboard page
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => '<link rel="stylesheet" href="' . asset('vendor/saccharine-dashboard/dashboard.css') . '">',
            scopes: \Saccharine\Dashboard\Filament\Pages\OperationalTriageBoard::class,
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn (): string => '<script defer src="' . asset('vendor/saccharine-dashboard/dashboard.js') . '"></script>',
            scopes: \Saccharine\Dashboard\Filament\Pages\OperationalTriageBoard::class,
        );
    }
}