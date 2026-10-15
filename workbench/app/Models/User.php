<?php

namespace Workbench\App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Minimal user model for the Workbench host application.
 *
 * Used with `actingAs()` to satisfy Filament's Authenticate middleware when
 * previewing or integration-testing the triage board page. Implements
 * FilamentUser so the panel grants access (Filament returns 403 for any
 * authenticated user that does not implement the contract). The model is never
 * persisted or queried in tests.
 */
class User extends Authenticatable implements FilamentUser
{
    protected $guarded = [];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
