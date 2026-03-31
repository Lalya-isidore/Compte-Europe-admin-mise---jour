<?php

return [
    'europe' => [
        'app_name' => 'FlashBilan',
        'client_login_url' => env('REGION_EUROPE_CLIENT_URL', 'http://localhost/public_html'),
        'default_devise' => '€',
        'default_country' => 'France',
        'default_address' => 'Paris, France',
        'fedapay_webhook_secret' => env('FEDAPAY_WEBHOOK_SECRET_EUROPE'),
        'fedapay_description' => 'Recharge FlashBilan',
        'welcome_sms' => 'Bienvenue sur FlashBilan %s %s ! Votre compte client a été créé avec un solde initial de 10 000 F CFA.',
        'sms_provider' => 'infobip',
        'auto_delete_compte' => false,
        // Coût de création de compte
        'compte_base_cost' => 4000,
        'compte_sms_cost' => 1000,       // coût additionnel si SMS activé
        'compte_sms_optional' => true,    // l'utilisateur choisit d'activer le SMS
    ],
    'afrique' => [
        'app_name' => 'FlashCompte',
        'client_login_url' => env('REGION_AFRIQUE_CLIENT_URL', 'http://localhost/public_html_Afriques'),
        'default_devise' => 'XOF',
        'default_country' => 'Bénin-City',
        'default_address' => 'Cotonou-Bénin',
        'fedapay_webhook_secret' => env('FEDAPAY_WEBHOOK_SECRET_AFRIQUE'),
        'fedapay_description' => 'Recharge FlashCompte',
        'welcome_sms' => 'Bienvenue sur FlashCompte %s %s ! Votre compte client a été créé avec un solde initial de 10 000 F CFA.',
        'sms_provider' => 'infobip',
        'auto_delete_compte' => true,
        // Coût de création de compte
        'compte_base_cost' => 4000,
        'compte_sms_cost' => 1000,        // coût additionnel si SMS activé
        'compte_sms_optional' => true,    // l'utilisateur choisit d'activer le SMS
    ],
];
