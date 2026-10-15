<?php

namespace Saccharine\Dashboard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Workbench\App\Models\User;

class TestCase extends Orchestra
{
    use WithWorkbench;

    /**
     * Enable package auto-discovery so Filament (and its render-hook system)
     * boots exactly as it would in a real host application.
     */
    protected $enablesPackageDiscoveries = true;

    /**
     * Define environment setup.
     *
     * Workbench reads package providers from `testbench.yaml`; this hook only
     * tunes runtime config for the test environment.
     */
    protected function getEnvironmentSetUp($app)
    {
        // Provide a standard 32-character base64 string for Laravel's encrypter
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYvnkFmTNFjq+95U=');

        // Filament needs a session-backed guard for its page middleware stack.
        $app['config']->set('session.driver', 'array');
    }

    /**
     * Create (and authenticate) a Workbench user for Filament-protected pages.
     */
    protected function authenticateWorkbenchUser(): User
    {
        $user = new User([
            'name' => 'Workbench User',
            'email' => 'workbench@example.test',
        ]);
        $user->id = 1;

        $this->actingAs($user);

        return $user;
    }
}
