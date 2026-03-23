<?php
// Usage: php scripts/check_fr_leaks_in_locales.php
// Compares each resources/lang/<locale>/emails.php to resources/lang/fr/emails.php
// Produces scripts/email_fr_leak_report.json

$base = __DIR__ . '/../resources/lang';
$frFile = $base . '/fr/emails.php';
if (!file_exists($frFile)) {
    fwrite(STDERR, "FR emails.php not found: $frFile\n");
    exit(1);
}

$fr = include $frFile;
if (!is_array($fr)) {
    fwrite(STDERR, "FR file did not return array\n");
    exit(1);
}

$locales = array_filter(scandir($base), function($d) use ($base) {
    return $d !== '.' && $d !== '..' && is_dir($base . '/' . $d);
});

$french_keywords = [
    'bonjour','merci','compte','virement','solde','montant','réinitialis','mot de passe','bienvenue','merci d','echec','échec','rembourse','transfert',
    'service client','contactez','cordialement','alerte','identifiants','connexion','réglage','transfert','débloc',"debloc",
];

$report = ['generated_at' => date('c'), 'locales' => []];

foreach ($locales as $loc) {
    $locFile = $base . '/' . $loc . '/emails.php';
    if (!file_exists($locFile)) {
        continue;
    }
    $arr = include $locFile;
    if (!is_array($arr)) {
        $report['locales'][$loc] = ['error' => 'file did not return array'];
        continue;
    }

    $identical_keys = [];
    $french_substrings = [];
    foreach ($fr as $key => $frVal) {
        $locVal = isset($arr[$key]) ? $arr[$key] : null;
        if ($locVal === null) {
            // missing key will be caught by other audit; ignore here
            continue;
        }
        // identical string (exact)
        if ($locVal === $frVal) {
            $identical_keys[] = $key;
            continue;
        }
        // lower-case check for French keywords inside value
        $lc = mb_strtolower(strip_tags((string)$locVal), 'UTF-8');
        foreach ($french_keywords as $kw) {
            if (mb_stripos($lc, $kw, 0, 'UTF-8') !== false) {
                $french_substrings[$key][] = $kw;
            }
        }
    }

    $report['locales'][$loc] = [
        'total_keys' => count($arr),
        'identical_count' => count($identical_keys),
        'identical_keys' => $identical_keys,
        'french_substrings' => $french_substrings,
    ];
}

$outFile = __DIR__ . '/email_fr_leak_report.json';
file_put_contents($outFile, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Report written to $outFile\n";
