<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define("LARAVEL_START", microtime(true));

// Buat semua direktori yang dibutuhkan Laravel di /tmp
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}


if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    return $maintenance;
}

require __DIR__ . '/../vendor/autoload.php';


/**
 * @var Application $app
 */
$app = require_once __DIR__ . "/../bootstrap/app.php";

// Override storage & bootstrap cache ke /tmp
$app->useStoragePath($storagePath);
$app->bootstrapPath('/tmp/bootstrap');

$app->handleRequest(Request::capture());
