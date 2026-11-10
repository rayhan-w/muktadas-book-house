<?php

/**
 * Muktada's Boighor - Root Entrypoint & cPanel public_html Bridge
 * Automatically routes root requests to the Laravel public directory.
 */

define('LARAVEL_START', microtime(true));

// Quick cache clearer for cPanel deployments
if (isset($_GET['clear_cache'])) {
    @array_map('unlink', glob(__DIR__ . '/storage/framework/views/*.php'));
    @array_map('unlink', glob(__DIR__ . '/bootstrap/cache/*.php'));
    echo "<h2 style='color:#0f2a44; font-family:sans-serif;'>✓ Laravel cache cleared successfully!</h2><p><a href='/'>Return to Home</a></p>";
    exit;
}

$publicIndex = __DIR__ . '/public/index.php';

if (file_exists($publicIndex)) {
    require_once $publicIndex;
} else {
    http_response_code(500);
    echo "<h1>Muktada's Boighor - Deployment Notice</h1>";
    echo "<p>Laravel public folder not found. Please ensure all project files are properly deployed.</p>";
}
