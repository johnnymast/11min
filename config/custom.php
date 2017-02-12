<?php

return [
    'mail_domain'             => env('MAIL_DOMAIN'),
    'admin_email'             => env('ADMIN_EMAIL'),
    'google_analytics_code'   => env('GOOGLE_ANALYTICS_CODE'),

    /**
     * Default SEO information
     */
    'default_seo_keywords'    => env('DEFAULT_SEO_KEYWORDS'),
    'default_seo_description' => env('DEFAULT_SEO_DESCRIPTION'),
    'default_og_url'          => env('DEFAULT_OG_URL'),
    'default_og_type'         => env('DEFAULT_OG_TYPE'),
    'default_og_title'        => env('DEFAULT_OG_TITLE'),
    'default_og_description'  => env('DEFAULT_OG_DESCRIPTION'),
    'default_og_image'        => env('DEFAULT_OG_IMAGE'),
];
