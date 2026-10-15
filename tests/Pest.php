<?php

use Saccharine\Dashboard\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Bind the Workbench-aware Testbench TestCase to the package's test suites.
| Providers are declared in `testbench.yaml` (the DashboardServiceProvider plus
| a minimal Filament panel so the render-hook integration is exercised).
|
*/

pest()->extend(TestCase::class)
    ->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
