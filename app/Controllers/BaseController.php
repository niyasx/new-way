<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * Shared controller utilities for HTML responses.
 */
abstract class BaseController
{
    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): string
    {
        $defaults = [
            'siteName' => config('site.name'),
            'siteTagline' => config('site.tagline'),
            'pageTitle' => config('seo.default_title'),
            'metaDescription' => config('seo.default_description'),
            'metaKeywords' => config('seo.keywords'),
            'canonicalUrl' => url(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'),
            'ogImage' => url((string) config('seo.og_image')),
            'showTicker' => true,
            'isHome' => false,
            'extraStylesheet' => null,
        ];

        return view('layouts/master', array_merge($defaults, $data, [
            'content' => view($view, array_merge($defaults, $data)),
        ]));
    }
}
