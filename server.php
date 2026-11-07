<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * Custom router script for PHP's built-in web server.
 * Enables high-performance static asset caching for Lighthouse optimization.
 */

$publicPath = __DIR__.'/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

$filePath = $publicPath.$uri;

// If the requested URI is a static file that exists in public/
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    // 1 year immutable cache for Vite-built versioned assets
    if (str_starts_with($uri, '/build/assets/')) {
        header('Cache-Control: public, max-age=31536000, immutable');
    } elseif (preg_match('/\.(css|js|woff2?|ttf|eot|svg|png|jpg|jpeg|gif|webp|ico)$/i', $uri)) {
        header('Cache-Control: public, max-age=86400');
    }

    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css'   => 'text/css; charset=UTF-8',
        'js'    => 'application/javascript; charset=UTF-8',
        'json'  => 'application/json',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'webp'  => 'image/webp',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
    ];

    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }

    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}

require_once $publicPath.'/index.php';
