<?php

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Saccharine\Dashboard\DashboardServiceProvider;
use Saccharine\Dashboard\Filament\Pages\OperationalTriageBoard;

/*
|--------------------------------------------------------------------------
| Workbench Integration Test
|--------------------------------------------------------------------------
|
| Boots the Dashboard package inside Orchestra Workbench with no host app:
| the asset route that serves the compiled Vue bundle, and the Filament
| render-hook integration that injects those assets onto the triage board.
|
*/

it('boots the package provider via testbench.yaml', function () {
    expect($this->app->getProviders(DashboardServiceProvider::class))->not->toBeEmpty();
});

it('registers the asset route', function () {
    expect(Route::getRoutes()->getRoutesByName())->toHaveKeys(['saccharine-dashboard.asset']);
});

it('serves the compiled dashboard.css with a stylesheet content type', function () {
    $response = $this->get(route('saccharine-dashboard.asset', ['file' => 'dashboard.css']));

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('text/css');

    // The route streams the package's public/dashboard.css via BinaryFileResponse.
    $file = $response->baseResponse->getFile();
    expect($file->getFilename())->toContain('dashboard.css')
        ->and($file->getSize())->toBeGreaterThan(0);
});

it('serves the compiled dashboard.js with a javascript content type', function () {
    $response = $this->get(route('saccharine-dashboard.asset', ['file' => 'dashboard.js']));

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('application/javascript');

    $file = $response->baseResponse->getFile();
    expect($file->getFilename())->toContain('dashboard.js')
        ->and($file->getSize())->toBeGreaterThan(0);
});

it('does not match asset routes for files other than the dashboard bundle', function () {
    $this->get('/saccharine-dashboard/evil.svg')->assertNotFound();
    $this->get('/saccharine-dashboard/dashboard.svg')->assertNotFound();
});

it('injects the dashboard asset tags into the Filament triage board page', function () {
    $this->authenticateWorkbenchUser();

    $response = $this->get('/workbench-admin/operations/triage');

    $response->assertOk();

    $html = $response->getContent();
    expect($html)
        ->toContain('rel="stylesheet"')
        ->toContain(route('saccharine-dashboard.asset', ['file' => 'dashboard.css']))
        ->toContain('<script defer src="' . route('saccharine-dashboard.asset', ['file' => 'dashboard.js']) . '">');
});

it('does not inject the dashboard assets into unrelated Filament pages', function () {
    $this->authenticateWorkbenchUser();

    $html = $this->get('/workbench-admin')->getContent();

    expect($html)
        ->not->toContain(route('saccharine-dashboard.asset', ['file' => 'dashboard.css']));
});

it('scopes the registered render hooks to the triage board page', function () {
    // The DashboardServiceProvider registers HEAD_END/BODY_END hooks scoped to
    // OperationalTriageBoard so only that page receives the asset tags.
    expect(FilamentView::hasRenderHook(PanelsRenderHook::HEAD_END, OperationalTriageBoard::class))->toBeTrue()
        ->and(FilamentView::hasRenderHook(PanelsRenderHook::BODY_END, OperationalTriageBoard::class))->toBeTrue()
        // And they are NOT registered unscoped (which would affect every page).
        ->and(FilamentView::hasRenderHook(PanelsRenderHook::HEAD_END))->toBeFalse();
});
