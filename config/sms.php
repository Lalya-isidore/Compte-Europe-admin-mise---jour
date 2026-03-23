<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Provider Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour le service d'envoi de SMS Pro
    |
    */

    'provider' => env('SMS_PROVIDER', 'infobip'), // twilio, vonage, infobip, etc.

    /*
    |--------------------------------------------------------------------------
    | Twilio Configuration
    |--------------------------------------------------------------------------
    */
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'phone_number' => env('TWILIO_PHONE_NUMBER'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Autres fournisseurs (à ajouter selon vos besoins)
    |--------------------------------------------------------------------------
    */
    'vonage' => [
        'api_key' => env('VONAGE_API_KEY'),
        'api_secret' => env('VONAGE_API_SECRET'),
        'from' => env('VONAGE_FROM'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Infobip Configuration
    |--------------------------------------------------------------------------
    */
    'infobip' => [
        'api_key' => env('INFOBIP_API_KEY'),
        'base_url' => env('INFOBIP_BASE_URL', 'https://m9pzm6.api.infobip.com'),
        'sender' => env('INFOBIP_SENDER', 'Movicredo'),
    ],

];
