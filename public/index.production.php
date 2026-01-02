<?php
/**
 * Production index.php untuk hosting
 * Upload file ini ke public_html/
 * 
 * Struktur:
 * /home/sistem18/laravel_core/  ← folder inti Laravel
 * /home/sistem18/public_html/   ← file ini + assets
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path ke folder Laravel (sesuaikan dengan struktur hosting)
$laravelPath = '/home/sistem18/laravel_core';

// Maintenance mode
if (file_exists($maintenance = $laravelPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader
require $laravelPath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request
(require_once $laravelPath.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
