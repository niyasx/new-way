<?php

declare(strict_types=1);

echo view('layouts/master', [
    'content' => '<section class="page-hero"><div class="wrap"><h1 class="section-title">Page <em>Not Found</em></h1><p class="contact-info-sub" style="margin-top:1.5rem">The page you requested does not exist or has been moved.</p><p style="margin-top:2rem"><a href="' . e(url('/')) . '" class="btn-primary">Return Home</a></p></div></section>',
    'pageTitle' => 'Page Not Found | ' . config('site.name'),
    'metaDescription' => 'The page you requested could not be found.',
    'canonicalUrl' => url('/'),
    'showTicker' => false,
    'bodyClass' => 'page-error',
]);
