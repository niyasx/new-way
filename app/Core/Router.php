<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Simple HTTP router matching method and path.
 */
final class Router
{
    /** @var array<string, array<string, array{0: class-string, 1: string}>> */
    private array $routes;

    public function __construct()
    {
        $this->routes = require dirname(__DIR__, 2) . '/config/routes.php';
    }

    /**
     * @return array{0: class-string, 1: string}|null
     */
    public function match(string $method, string $path): ?array
    {
        $method = strtoupper($method);
        $path = $this->normalizePath($path);

        return $this->routes[$method][$path] ?? null;
    }

    private function normalizePath(string $path): string
    {
        $path = parse_url($path, PHP_URL_PATH) ?: '/';
        $path = '/' . trim($path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }
}
