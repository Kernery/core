<?php

return [
    'app_name' => env('APP_NAME', 'Kernery'),
    'allow_sanitize_value' => env('ALLOW_SANITIZE_VALUE', true),
    'allow_sanitize_json' => env('ALLOW_SANITIZE_JSON', false),
    'admin_url' => env('ADMIN_URL', 'vp-admin'),
    'app_locale' => env('APP_LOCALE', 'en'),
    'https_support' => env('HTTPS_SUPPORT', false),
    'app_update' => env('APP_UPDATE', false),
    'less_secure_app' => env('LESS_SECURE_APP', false),
    'strict_db' => env('STRICT_DB', true),
    'enable_ini_set' => env('ENABLE_INI_SET', true),
    'disable_csrf_verification' => env('DISABLE_CSRF_VERIFICATION', false),
    'php_upgrade_required' => env('PHP_UPGRADE_REQUIRED', false),
    'use_uuid_for_id' => env('USE_UUID_FOR_ID', false),
    'use_ulid_for_id' => env('USE_ULID_FOR_ID', false),
    'use_id' => env('USE_ID', 'BIGINT'),
    'use_font_size' => env('USE_FONT_SIZE', '18px'),
    'enable_app_font' => env('ENABLE_APP_FONT', true),
    'app_font_url' => env('APP_FONT_URL', 'https://fonts.googleapis.com'),
    'enable_font_caching' => env('ENABLE_FONT_CACHING', true),
    'custom_app_fonts' => env('CUSTOM_APP_FONTS'),
    'app_font_name' => [

    ],
    'report_app_error' => [
        'channel' => [
            'via_slack' => env('SLACK_REPORTING_ENABLED', false),
            'via_email' => env('EMAIL_REPORTING_ENABLED', false)
        ],
        'ignore_bots' => [
            'slurp',
            'bingbot',
            'googlebot'
        ]
    ],
    'app_text_editor' => [
        
    ]
];
