<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * Loads reusable UI components from app/Components.
 */
final class ComponentLoader
{
    /**
     * @param array<string, mixed> $data
     */
    public static function render(string $name, array $data = []): void
    {
        $file = dirname(__DIR__) . '/Components/' . $name . '.php';
        if (!is_file($file)) {
            throw new \RuntimeException("Component not found: {$name}");
        }

        extract($data, EXTR_SKIP);
        require $file;
    }
}
