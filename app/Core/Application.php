<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Application bootstrap: routing, security headers, response dispatch.
 */
final class Application
{
    private string $basePath;

    private Router $router;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
        $this->router = new Router();
    }

    public function run(): void
    {
        $this->sendSecurityHeaders();

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        $handler = $this->router->match($method, $uri);

        if ($handler === null) {
            $this->notFound();
            return;
        }

        [$class, $action] = $handler;
        $controller = new $class();

        if (!method_exists($controller, $action)) {
            $this->notFound();
            return;
        }

        $response = $controller->{$action}();
        $this->emit($response);
    }

    private function sendSecurityHeaders(): void
    {
        $headers = config('security_headers', []);
        if (!is_array($headers)) {
            return;
        }

        foreach ($headers as $name => $value) {
            header("{$name}: {$value}");
        }
    }

    /**
     * @param string|array{body?: string, status?: int, headers?: array<string, string>} $response
     */
    private function emit(string|array $response): void
    {
        if (is_string($response)) {
            echo $response;
            return;
        }

        $status = $response['status'] ?? 200;
        http_response_code($status);

        foreach ($response['headers'] ?? [] as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $response['body'] ?? '';
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo view('pages/errors/404', [
            'pageTitle' => 'Page Not Found',
            'metaDescription' => 'The page you requested could not be found.',
        ]);
    }
}
