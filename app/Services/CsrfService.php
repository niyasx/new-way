<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Session-backed CSRF token generation and validation.
 */
final class CsrfService
{
    private const SESSION_KEY = '_csrf_token';

    private static ?self $instance = null;

    private function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_samesite' => 'Lax',
                'use_strict_mode' => true,
            ]);
        }
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    public function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return (string) $_SESSION[self::SESSION_KEY];
    }

    public function validate(?string $token): bool
    {
        if ($token === null || $token === '') {
            return false;
        }

        $stored = $_SESSION[self::SESSION_KEY] ?? '';

        return is_string($stored) && hash_equals($stored, $token);
    }

    public function regenerate(): void
    {
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
    }
}
