<?php

/*
|--------------------------------------------------------------------------
| Public Site Details
|--------------------------------------------------------------------------
|
| Business details shown on the public site (contact section, footer,
| structured data for search engines). Anything left empty is simply not
| rendered, so the site never shows placeholder contact details.
|
*/

return [

    'name' => env('SITE_NAME', 'Æther Marketing Agency'),

    'tagline' => 'Making your business profitable for today & tomorrow.',

    'description' => "Making your business profitable for today & tomorrow. Let your brand's story spark across digital aether.",

    // Default image for link previews (Facebook, LinkedIn, WhatsApp, X...). 1200×630 works best.
    'og_image' => env('SITE_OG_IMAGE', 'media/og-image.jpg'),

    'contact' => [
        'email' => env('SITE_EMAIL'),
        'phone' => env('SITE_PHONE'),
        'location' => env('SITE_LOCATION'),
        // A Calendly / Google Calendar booking page, shown as "Book a call".
        'booking_url' => env('SITE_BOOKING_URL'),
        'map_url' => env('SITE_MAP_URL'),
    ],

    'social' => array_filter([
        'Instagram' => env('SOCIAL_INSTAGRAM'),
        'LinkedIn' => env('SOCIAL_LINKEDIN'),
        'Facebook' => env('SOCIAL_FACEBOOK'),
        'TikTok' => env('SOCIAL_TIKTOK'),
        'Behance' => env('SOCIAL_BEHANCE'),
    ]),

    'analytics' => [
        // Plausible is cookieless: no consent banner needed. Set to your site's domain.
        'plausible_domain' => env('ANALYTICS_PLAUSIBLE_DOMAIN'),
        // GA4 sets cookies, so it only loads after the visitor accepts the cookie banner.
        'ga4_id' => env('ANALYTICS_GA4_ID'),
    ],

    // Shown on the privacy page as the date of the last policy change.
    'privacy_updated' => env('SITE_PRIVACY_UPDATED', '2026-09-25'),

];
