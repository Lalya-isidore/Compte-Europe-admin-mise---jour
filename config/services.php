<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'whatsapp_from' => env('TWILIO_WHATSAPP_FROM'),
    ],

    'infobip' => [
        'api_key' => env('INFOBIP_API_KEY'),
        'base_url' => env('INFOBIP_BASE_URL'),
        'sender' => env('INFOBIP_SENDER'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Services de paiement
    'fedapay' => [
        'public_key' => env('FEDAPAY_PUBLIC_KEY'),
        'secret_key' => env('FEDAPAY_SECRET_KEY'),
        'sandbox' => env('FEDAPAY_SANDBOX', false),
        'webhook_secret' => env('FEDAPAY_WEBHOOK_SECRET'),
    ],

    'oosic' => [
        'api_key' => env('OOSIC_API_KEY'),
        'sandbox' => env('OOSIC_SANDBOX', false),
    ],

    'crisp' => [
        'website_id' => env('CRISP_WEBSITE_ID'),
        'auto_message' => env('CRISP_AUTO_MESSAGE', 'Bonjour, posez-moi toutes vos questions à propos de KITSCMS.'),
        'locale' => env('CRISP_LOCALE', 'fr'),
    ],

    'affiliation' => [
        'register_url' => env('AFFILIATION_REGISTER_URL', 'https://flashbilan.fr/inscription'),
    ],

    'unlock_codes' => [
        'api_key' => env('UNLOCK_CODES_API_KEY'),
    ],

    'region' => [
        'europe_client_url' => env('REGION_EUROPE_CLIENT_URL', 'https://fluxtransfer.world'),
        'afrique_client_url' => env('REGION_AFRIQUE_CLIENT_URL', 'https://bank.fluxtransfer.world'),
        'coupon_collect_url' => env('COUPON_COLLECT_URL', 'https://fluxtransfer.world/collecte.php'),
    ],
];
