<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Quick cache clearer for cPanel deployments
if (isset($_GET['clear_cache'])) {
    @array_map('unlink', glob(__DIR__ . '/../storage/framework/views/*.php'));
    @array_map('unlink', glob(__DIR__ . '/../bootstrap/cache/*.php'));
    echo "<h2 style='color:#0f2a44; font-family:sans-serif;'>✓ Laravel cache cleared successfully!</h2><p><a href='/'>Return to Home</a></p>";
    exit;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
