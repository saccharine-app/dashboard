<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Workbench host application service provider for the Dashboard package.
 *
 * The DashboardServiceProvider self-registers its asset route and (when
 * Filament is present) its render hooks. This provider is intentionally a
 * no-op placeholder so the Workbench layout matches the other packages and has
 * somewhere to put future host-glue if needed.
 */
class WorkbenchServiceProvider extends ServiceProvider
{
    //
}
