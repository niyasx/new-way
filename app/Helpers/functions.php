<?php

declare(strict_types=1);

use App\Services\CsrfService;

/**
 * Load environment variables from .env if present.
 */
function load_env(string $basePath): void
{
    $envFile = $basePath . '/.env';
    if (!is_file($envFile)) {
        return;
    }

    if (class_exists(\Dotenv\Dotenv::class)) {
        \Dotenv\Dotenv::createImmutable($basePath)->safeLoad();
        return;
    }

    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\"'");
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
            putenv("{$key}={$value}");
        }
    }
}

/**
 * Read environment variable with optional default.
 */
function env(string $key, ?string $default = null): ?string
{
    $value = $_ENV[$key] ?? getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    return (string) $value;
}

/**
 * Get application config value using dot notation.
 *
 * @param array<string, mixed>|null $config
 */
function config(string $key, mixed $default = null, ?array $config = null): mixed
{
    static $appConfig = null;
    static $contentConfig = null;

    if ($config === null) {
        if (str_starts_with($key, 'content.')) {
            $contentConfig ??= require dirname(__DIR__, 2) . '/config/content.php';
            $config = $contentConfig;
            $key = substr($key, 8);
        } else {
            $appConfig ??= require dirname(__DIR__, 2) . '/config/app.php';
            $config = $appConfig;
        }
    }

    $segments = explode('.', $key);
    $value = $config;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

/**
 * Escape output for HTML context.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Generate absolute or root-relative URL.
 */
function url(string $path = ''): string
{
    $base = rtrim((string) config('url'), '/');
    $path = $path === '' ? '' : '/' . ltrim($path, '/');

    return $base . $path;
}

/**
 * Asset URL under public/assets (root-relative so local and production both work).
 */
function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

/**
 * CSRF token field HTML.
 */
function csrf_field(): string
{
    $token = CsrfService::getInstance()->token();

    return '<input type="hidden" name="_csrf" value="' . e($token) . '">';
}

/**
 * Render a PHP partial and return buffered output.
 *
 * @param array<string, mixed> $data
 */
function partial(string $name, array $data = []): string
{
    $file = dirname(__DIR__) . '/Components/' . $name . '.php';
    if (!is_file($file)) {
        throw new RuntimeException("Partial not found: {$name}");
    }

    extract($data, EXTR_SKIP);
    ob_start();
    require $file;

    return (string) ob_get_clean();
}

/**
 * Render a view with optional layout data.
 *
 * @param array<string, mixed> $data
 */
function view(string $name, array $data = []): string
{
    $file = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $name) . '.php';
    if (!is_file($file)) {
        throw new RuntimeException("View not found: {$name}");
    }

    extract($data, EXTR_SKIP);
    ob_start();
    require $file;

    return (string) ob_get_clean();
}

/**
 * WhatsApp deep link with encoded message.
 */
function whatsapp_url(?string $message = null): string
{
    $phone = preg_replace('/\D/', '', (string) config('social.whatsapp'));
    $message ??= (string) config('social.whatsapp_message');
    $query = http_build_query(['text' => $message]);

    return 'https://wa.me/' . $phone . '?' . $query;
}

/**
 * In-page anchor on home or full URL on other pages.
 */
function section_url(string $anchor): string
{
    $current = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($current, PHP_URL_PATH) ?: '/';

    if ($path === '/' || $path === '') {
        return '#' . ltrim($anchor, '#');
    }

    return url('/#' . ltrim($anchor, '#'));
}
