<?php

/**
 * Muktada's Boighor - Root Entrypoint & cPanel public_html Bridge
 * Automatically routes root requests to the Laravel public directory.
 */

define('LARAVEL_START', microtime(true));

$publicIndex = __DIR__ . '/public/index.php';

if (file_exists($publicIndex)) {
    require_once $publicIndex;
} else {
    http_response_code(500);
    echo "<h1>Muktada's Boighor - Deployment Notice</h1>";
    echo "<p>Laravel public folder not found. Please ensure all project files are properly deployed.</p>";
}
