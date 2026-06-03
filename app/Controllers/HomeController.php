<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * Home page — full single-page experience with all sections.
 */
final class HomeController extends BaseController
{
    public function index(): string
    {
        return $this->render('pages/home', [
            'pageTitle' => config('seo.default_title'),
            'metaDescription' => config('seo.default_description'),
            'canonicalUrl' => url('/'),
            'isHome' => true,
            'showTicker' => true,
        ]);
    }
}
