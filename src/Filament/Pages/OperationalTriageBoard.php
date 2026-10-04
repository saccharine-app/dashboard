<?php

namespace Saccharine\Dashboard\Filament\Pages;

use Filament\Pages\Page;

class OperationalTriageBoard extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationLabel = 'Triage Board';
    protected static \UnitEnum|string|null $navigationGroup = 'Operations';
    protected static ?string $slug = 'operations/triage';

    // Points to the package Blade view
    protected string $view = 'saccharine-dashboard::filament.pages.operational-triage-board';

    // Allow full width to accommodate multi-column triage boards
    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';

    public function getHeading(): string
    {
        return 'Operational Triage Board';
    }
}