<?php

declare(strict_types=1);

use App\Controllers\ContactController;
use App\Controllers\HomeController;
use App\Controllers\PageController;

/**
 * Route definitions: HTTP method => path => [Controller::class, 'method'].
 *
 * @return array<string, array<string, array{0: class-string, 1: string}>>
 */
return [
    'GET' => [
        '/' => [HomeController::class, 'index'],
        '/about' => [PageController::class, 'about'],
        '/services' => [PageController::class, 'services'],
        '/contact' => [PageController::class, 'contact'],
        '/privacy-policy' => [PageController::class, 'privacy'],
        '/terms' => [PageController::class, 'terms'],
    ],
    'POST' => [
        '/contact/submit' => [ContactController::class, 'submit'],
    ],
];
