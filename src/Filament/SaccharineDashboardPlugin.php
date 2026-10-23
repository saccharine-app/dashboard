<?php

namespace Saccharine\Dashboard\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Saccharine\Dashboard\Filament\Pages\OperationalTriageBoard;

class SaccharineDashboardPlugin implements Plugin
{
    public function getId(): string
    {
        return 'saccharine-dashboard';
    }

    public function getPluginName(): string
    {
        return 'Operational Triage Board';
    }

    public function getNavigationIcon(): string
    {
        return 'heroicon-o-view-columns';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                OperationalTriageBoard::class,
            ])
            ->resources([])
            ->middleware([]);
    }

    public function boot(Panel $panel): void
    {
        // No plugin-level bootstrapping required.
        // The OperationalTriageBoard page owns its asset registration through
        // FilamentView::registerRenderHook() scoped to this page.
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
