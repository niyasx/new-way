<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * Secondary pages: about, services, contact, legal.
 */
final class PageController extends BaseController
{
    public function about(): string
    {
        return $this->render('pages/about', [
            'pageTitle' => 'About Us | ' . config('site.name'),
            'metaDescription' => 'Learn about New Way Consultancy — Kerala\'s trusted career partner in Perinthalmanna for domestic and overseas placements.',
            'canonicalUrl' => url('/about'),
            'showTicker' => false,
            'extraStylesheet' => 'css/subpages.css',
        ]);
    }

    public function services(): string
    {
        return $this->render('pages/services', [
            'pageTitle' => 'Our Services | ' . config('site.name'),
            'metaDescription' => 'Career counseling, job placement, visa guidance, resume building, and document attestation services in Perinthalmanna, Kerala.',
            'canonicalUrl' => url('/services'),
            'showTicker' => false,
            'extraStylesheet' => 'css/subpages.css',
        ]);
    }

    public function contact(): string
    {
        return $this->render('pages/contact', [
            'pageTitle' => 'Contact Us | ' . config('site.name'),
            'metaDescription' => 'Contact New Way Consultancy in Perinthalmanna. Call, WhatsApp, email, or send a message — we respond within 24 hours.',
            'canonicalUrl' => url('/contact'),
            'showTicker' => false,
            'extraStylesheet' => 'css/subpages.css',
        ]);
    }

    public function privacy(): string
    {
        return $this->render('pages/privacy', [
            'pageTitle' => 'Privacy Policy | ' . config('site.name'),
            'metaDescription' => 'Privacy policy for New Way Consultancy website and contact forms.',
            'canonicalUrl' => url('/privacy-policy'),
            'showTicker' => false,
            'extraStylesheet' => 'css/subpages.css',
        ]);
    }

    public function terms(): string
    {
        return $this->render('pages/terms', [
            'pageTitle' => 'Terms of Service | ' . config('site.name'),
            'metaDescription' => 'Terms of service for using the New Way Consultancy website.',
            'canonicalUrl' => url('/terms'),
            'showTicker' => false,
            'extraStylesheet' => 'css/subpages.css',
        ]);
    }
}
