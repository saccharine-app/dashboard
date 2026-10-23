<?php

namespace Saccharine\Dashboard;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Saccharine\Dashboard\Http\Controllers\DashboardAssetController;
use Saccharine\Dashboard\Filament\Pages\OperationalTriageBoard;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load views for the demo route
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'saccharine-dashboard');

        // Serve the compiled CSS/JS straight from the package so host apps
        // never need to run `vendor:publish`. A controller (rather than a
        // closure) keeps the route compatible with `php artisan route:cache`.
        Route::get('saccharine-dashboard/{file}', DashboardAssetController::class)
            ->where('file', 'dashboard\.(js|css)')
            ->name('saccharine-dashboard.asset');

        // Register assets and page only if Filament is installed
        if (class_exists(\Filament\FilamentManager::class)) {
            $this->registerFilamentIntegration();
        }
    }

    protected function registerFilamentIntegration(): void
    {
        // Register the dashboard plugin with the current panel.
        // The plugin handles page registration, asset hooks, and middleware.
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => '<link rel="stylesheet" href="' . route('saccharine-dashboard.asset', ['file' => 'dashboard.css']) . '">',
            scopes: OperationalTriageBoard::class,
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn (): string => '<script defer src="' . route('saccharine-dashboard.asset', ['file' => 'dashboard.js']) . '"></script>',
            scopes: OperationalTriageBoard::class,
        );
    }
}