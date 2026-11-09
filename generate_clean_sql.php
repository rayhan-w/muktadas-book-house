<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Switch to SQLite in memory
config([
    'database.default' => 'sqlite',
    'database.connections.sqlite' => [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => true,
    ],
]);

\Illuminate\Support\Facades\DB::purge('sqlite');
\Illuminate\Support\Facades\DB::reconnect('sqlite');

echo "Running migrations...\n";
\Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);

echo "Running seeders...\n";
\Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);

echo "Seeding completed successfully!\n";

// Now dump tables
$tables = ['users', 'categories', 'books', 'book_category', 'site_settings', 'memberships', 'coupons', 'reviews'];

$output = "-- ==============================================================\n";
$output .= "-- মুক্তাদার বইঘর (Muktada's Boighor)\n";
$output .= "-- 100% CLEAN UTF-8 DATABASE DUMP & REPAIR SCRIPT\n";
$output .= "-- Generated at: " . date('Y-m-d H:i:s') . "\n";
$output .= "-- ==============================================================\n\n";
$output .= "SET NAMES utf8mb4;\n";
$output .= "SET CHARACTER SET utf8mb4;\n";
$output .= "SET foreign_key_checks = 0;\n\n";

foreach ($tables as $tbl) {
    echo "Exporting table: {$tbl}...\n";
    $rows = \Illuminate\Support\Facades\DB::table($tbl)->get();
    if ($rows->isEmpty()) continue;

    $output .= "-- Table: {$tbl}\n";
    $output .= "TRUNCATE TABLE `{$tbl}`;\n";

    foreach ($rows as $row) {
        $cols = [];
        $vals = [];
        foreach ((array)$row as $col => $val) {
            $cols[] = "`{$col}`";
            if ($val === null) {
                $vals[] = "NULL";
            } else {
                $escaped = str_replace(["\\", "'"], ["\\\\", "\\'"], (string)$val);
                // Also escape newlines for clean SQL
                $escaped = str_replace(["\r\n", "\r", "\n"], ["\\n", "\\n", "\\n"], $escaped);
                $vals[] = "'{$escaped}'";
            }
        }
        $colStr = implode(', ', $cols);
        $valStr = implode(', ', $vals);
        $output .= "INSERT INTO `{$tbl}` ({$colStr}) VALUES ({$valStr});\n";
    }
    $output .= "\n";
}

$output .= "SET foreign_key_checks = 1;\n";

file_put_contents(__DIR__ . '/clean_database_utf8.sql', $output);
echo "Successfully generated clean_database_utf8.sql (" . strlen($output) . " bytes)\n";
