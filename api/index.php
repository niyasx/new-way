<?php

declare(strict_types=1);

/**
 * Vercel serverless entrypoint — front controller for all HTTP requests.
 */

$basePath = dirname(__DIR__);

require $basePath . '/vendor/autoload.php';

load_env($basePath);

if (config('debug')) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

$app = new App\Core\Application($basePath);
$app->run();
