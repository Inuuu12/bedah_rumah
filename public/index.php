<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Pastikan folder cache storage selalu tersedia (mencegah InvalidArgumentException di shared hosting/cPanel)
$storageDirs = [
    __DIR__.'/../storage/framework/views',
    __DIR__.'/../storage/framework/sessions',
    __DIR__.'/../storage/framework/cache/data',
    __DIR__.'/../bootstrap/cache',
];
foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
