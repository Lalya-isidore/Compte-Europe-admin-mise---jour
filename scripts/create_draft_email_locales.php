<?php
// CLI script: create DRAFT email locale files by copying fr/emails.php
// Usage: php create_draft_email_locales.php [--locales=en,es,pt] [--all]

$root = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
$frPath = $root . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'fr' . DIRECTORY_SEPARATOR . 'emails.php';

if (!file_exists($frPath)) {
    echo "Fichier FR introuvable: $frPath\n";
    exit(1);
}

$frContents = file_get_contents($frPath);

$opts = getopt('', ['locales::', 'all']);

$requested = [];
if (isset($opts['all'])) {
    // gather all locale directories under resources/lang except 'fr'
    $langDir = $root . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;
    $dirs = scandir($langDir);
    foreach ($dirs as $d) {
        if ($d === '.' || $d === '..' || $d === 'fr') continue;
        if (is_dir($langDir . $d)) $requested[] = $d;
    }
} elseif (!empty($opts['locales'])) {
    $requested = array_map('trim', explode(',', $opts['locales']));
}

if (empty($requested)) {
    echo "Aucune locale demandée. Usage:\n";
    echo "  php create_draft_email_locales.php --locales=en,es,pt\n";
    echo "  php create_draft_email_locales.php --all\n";
    exit(1);
}

$now = date('Y-m-d H:i:s');
foreach ($requested as $locale) {
    $locale = trim($locale);
    if ($locale === '' || $locale === 'fr') continue;
    $targetDir = $root . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
    if (!is_dir($targetDir)) {
        echo "Création du dossier locale: $targetDir\n";
        if (!mkdir($targetDir, 0755, true)) {
            echo "Échec création du dossier pour $locale\n";
            continue;
        }
    }
    $targetPath = $targetDir . 'emails.php';
    if (file_exists($targetPath)) {
        // backup existing file
        $bak = $targetPath . '.bak-' . str_replace(':', '-', $now);
        copy($targetPath, $bak);
        echo "Backup créé: $bak\n";
    }

    $header = "<?php\n// DRAFT COPY of resources/lang/fr/emails.php\n// Generated: $now\n// NOTE: This file is a DRAFT copy copied from 'fr' to ensure all keys exist.\n// Please translate the values into '$locale' and remove this notice.\n\n";

    // Avoid embedding a second '<?php' inside an already-open PHP block.
    // Strip a leading '<?php' from the FR contents if present, so the final
    // file contains only a single opening PHP tag (from the header).
    $frStripped = preg_replace('/^\s*<\?php\s*/i', '', $frContents);

    // Write file (keeps contents identical to FR but with a single PHP open tag)
    if (file_put_contents($targetPath, $header . $frStripped) === false) {
        echo "Échec écriture fichier pour $locale\n";
    } else {
        echo "Fichier DRAFT créé: $targetPath\n";
    }
}

echo "Terminé. Vérifie les fichiers générés avant commit.\n";
