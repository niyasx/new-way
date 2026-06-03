<?php

declare(strict_types=1);

/**
 * Application configuration — values from environment with sensible defaults.
 *
 * @return array<string, mixed>
 */
return [
    'name' => env('APP_NAME', 'New Way Consultancy'),
    'env' => env('APP_ENV', 'production'),
    'url' => rtrim(env('APP_URL', 'http://localhost'), '/'),
    'debug' => filter_var(env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN),
    'key' => env('APP_KEY', ''),

    'site' => [
        'name' => env('APP_NAME', 'New Way Consultancy'),
        'tagline' => 'Perinthalmanna · Kerala',
        'email' => env('SITE_EMAIL', 'newwaypmna@gmail.com'),
        'phone_primary' => env('SITE_PHONE_PRIMARY', '+918086740392'),
        'phone_primary_display' => '+91 80867 40392',
        'phone_secondary' => env('SITE_PHONE_SECONDARY', '+917907530899'),
        'phone_secondary_display' => '+91 79075 30899',
        'address' => [
            'line1' => 'KIMS Avenue Building, Shanti Nagar',
            'line2' => 'Perinthalmanna, Kerala 679322',
            'country' => 'India',
        ],
        'maps_url' => 'https://maps.google.com/?q=KIMS+Avenue+Building+Shanti+Nagar+Perinthalmanna+Kerala',
        'hours' => 'Monday – Saturday: 9:30 AM – 6:00 PM',
        'hours_closed' => 'Sunday: Closed',
        'domain' => 'new-way.in',
        'location' => 'Perinthalmanna, Kerala',
    ],

    'social' => [
        'whatsapp' => env('SITE_PHONE_PRIMARY', '918086740392'),
        'whatsapp_message' => "Hi New Way Consultancy! I'm interested in your services. Please guide me.",
    ],

    'seo' => [
        'default_title' => 'New Way Consultancy | Career & Placement Experts — Perinthalmanna, Kerala',
        'default_description' => "Kerala's trusted career consultancy. Overseas job placement, resume building, visa guidance, and career counseling in Perinthalmanna.",
        'keywords' => 'career consultancy, job placement, Perinthalmanna, Kerala, overseas jobs, Gulf placement, visa guidance, resume building',
        'og_image' => '/assets/images/og-default.jpg',
        'twitter_handle' => '',
    ],

    'forms' => [
        'contact_enabled' => filter_var(env('CONTACT_FORM_ENABLED', 'true'), FILTER_VALIDATE_BOOLEAN),
        'formsubmit_endpoint' => env('FORM_SUBMIT_ENDPOINT', 'https://formsubmit.co/ajax/newwaypmna@gmail.com'),
    ],

    'mail' => [
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => (int) env('MAIL_PORT', '587'),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'from_address' => env('MAIL_FROM_ADDRESS', 'newwaypmna@gmail.com'),
        'from_name' => env('MAIL_FROM_NAME', 'New Way Consultancy'),
    ],

    'security_headers' => [
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'X-XSS-Protection' => '1; mode=block',
        'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://formsubmit.co; frame-ancestors 'self';",
    ],
];
