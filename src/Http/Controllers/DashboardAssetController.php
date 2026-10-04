<?php

namespace Saccharine\Dashboard\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardAssetController
{
    /**
     * Serve a compiled dashboard asset straight from the package.
     *
     * The route constrains {file} to dashboard.js|dashboard.css, and the
     * is_file() check below guarantees we never serve anything else.
     */
    public function __invoke(string $file): BinaryFileResponse
    {
        $path = dirname(__DIR__, 3) . '/public/' . $file; // src/Http/Controllers -> package root

        abort_unless(is_file($path), 404);

        // Set the MIME type explicitly. Symfony's content-based mime guesser
        // reports text/plain for CSS, which browsers refuse to apply as a
        // stylesheet, so we must not rely on it.
        $contentType = str_ends_with($file, '.css')
            ? 'text/css'
            : 'application/javascript';

        // BinaryFileResponse sets Last-Modified/ETag headers, so conditional
        // requests are handled automatically.
        return response()->file($path, ['Content-Type' => $contentType]);
    }
}
