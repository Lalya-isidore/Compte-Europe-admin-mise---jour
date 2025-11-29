<?php
// Usage: php send_all_test_emails.php recipient@example.com tr,fr

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SafeMailService;
use App\Models\Compte;
use App\Models\Transfer;

$recipient = $argv[1] ?? 'lalyaisidore@gmail.com';
$localeArg = $argv[2] ?? null; // comma-separated locales
$locales = $localeArg ? array_filter(array_map('trim', explode(',', $localeArg))) : [app()->getLocale() ?? 'fr'];

// Dummy compte
$compte = new Compte([
    'nom' => 'Test',
    'prenom' => 'Testeur',
    'email' => $recipient,
    'password' => 'secret123',
    'devise' => 'EUR',
    'lang' => $locales[0] ?? app()->getLocale(),
    'account_balance' => 123.45,
]);

// Dummy transfer
$transfer = new Transfer([
    'solidvire' => 42.50,
    'beneficiary_name' => 'Bénéficiaire Test',
    'created_at' => now(),
]);

// Map of label => factory closure that returns a Mailable instance
$tests = [
    'CompteCreeMail' => function() use ($compte) {
        return new App\Mail\CompteCreeMail(['welcome' => true], $compte);
    },
    'CompteActiveMail' => function() use ($compte) {
        return new App\Mail\CompteActiveMail($compte);
    },
    'CompteBloqueMail' => function() use ($compte) {
        return new App\Mail\CompteBloqueMail($compte);
    },
    'CodeDeblocageTransfertEmail' => function() use ($compte) {
        return new App\Mail\CodeDeblocageTransfertEmail(['code' => '123456'], $compte);
    },
    'CodeDeblocageUtiliseMail' => function() use ($compte, $transfer) {
        return new App\Mail\CodeDeblocageUtiliseMail($compte, ['transfer' => $transfer]);
    },
    'VirementReussiMail' => function() use ($compte, $transfer) {
        return new App\Mail\VirementReussiMail(['note' => 'OK'], $compte, $transfer);
    },
    'VirementEchecMail' => function() use ($compte, $transfer) {
        return new App\Mail\VirementEchecMail(['reason' => 'Insufficient funds'], $compte, $transfer);
    },
    'SoldeAugmente' => function() use ($compte) {
        return new App\Mail\SoldeAugmente($compte, 100.00);
    },
    'SoldeDiminue' => function() use ($compte) {
        return new App\Mail\SoldeDiminue($compte, 25.00);
    },
    'RemborsementMail' => function() use ($compte, $transfer) {
        return new App\Mail\RemborsementMail(['refund' => true], $compte, $transfer);
    },
    'TestGermanMail' => function() use ($compte) {
        return new App\Mail\TestGermanMail($compte);
    },
    'TestTurkishMail' => function() use ($compte) {
        return new App\Mail\TestTurkishMail($compte);
    },
    'MailErrorAlert' => function() use ($compte) {
        // This mail expects different params; construct minimally
        return new App\Mail\MailErrorAlert(['date' => now()->toDateTimeString()], $compte->email, 'TestContext', 'Simulated error');
    },
];

$report = [];
foreach ($locales as $locale) {
    echo "\n--- Testing locale: $locale ---\n";
    foreach ($tests as $name => $factory) {
        echo "Sending $name to $recipient... ";
        try {
            $mailable = $factory();
            $ok = SafeMailService::send($recipient, $mailable, "Test:$name", $locale);
            $report[] = [$locale, $name, $ok ? 'ok' : 'failed'];
            echo $ok ? "OK\n" : "FAILED\n";
        } catch (Throwable $e) {
            $report[] = [$locale, $name, 'error', $e->getMessage()];
            echo "ERROR: " . $e->getMessage() . "\n";
        }
    }
}

// Summary
echo "\nSummary:\n";
foreach ($report as $r) {
    echo implode(' | ', $r) . "\n";
}

echo "\nDone. Check storage/logs/laravel.log for details.\n";

