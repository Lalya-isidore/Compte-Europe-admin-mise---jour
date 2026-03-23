<#
setup_local.ps1
Script d'installation / remise en état pour une installation locale sous XAMPP (Windows PowerShell)
Usage:
  - Ouvrir PowerShell en tant qu'administrateur
  - Se placer dans le dossier du projet (ex: cd C:\xampp\htdocs\CompteEurope)
  - Lancer : .\setup_local.ps1 -RunAll -BuildAssets -Migrate

Options:
  -RunAll       : Exécute les étapes principales (composer install, key:generate, storage:link, optimize:clear)
  -BuildAssets  : Lance `npm install` puis `npm run build` (nécessite Node.js)
  -Migrate      : Lance `php artisan migrate` (veiller à la config .env et à la base)
  -NoCache      : Si présent, évite de regénérer les caches (config/route/view)
  -TailLogs     : Affiche en continu les derniers logs Laravel après les opérations
  -Help         : Affiche cette aide

Remarques:
  - Vérifier que PHP/Composer/Node/NPM sont accessibles depuis le PATH.
  - Le script est sûr mais veillez à avoir une sauvegarde avant d'exécuter les migrations en production.
#>

param(
    [switch]$RunAll,
    [switch]$BuildAssets,
    [switch]$Migrate,
    [switch]$NoCache,
    [switch]$TailLogs,
    [switch]$Help
)

if ($Help) {
    Get-Content -Path $MyInvocation.MyCommand.Path | Select-Object -First 1 -Skip 0
    Write-Host "Usage: .\setup_local.ps1 -RunAll -BuildAssets -Migrate -TailLogs" -ForegroundColor Cyan
    exit 0
}

function Run-Command {
    param(
        [string]$Cmd,
        [int]$TimeoutSec = 0
    )
    Write-Host "-> $Cmd" -ForegroundColor Yellow
    $proc = Start-Process -FilePath 'powershell' -ArgumentList "-NoProfile -NoLogo -Command &{ $Cmd }" -Wait -PassThru -WindowStyle Hidden
    if ($proc.ExitCode -ne 0) {
        Write-Host "Commande échouée (exit code $($proc.ExitCode)): $Cmd" -ForegroundColor Red
        return $false
    }
    return $true
}

function Check-Tool {
    param([string]$Tool)
    $which = Get-Command $Tool -ErrorAction SilentlyContinue
    if (-not $which) {
        Write-Host "Oups: $Tool n'est pas trouvé dans le PATH. Installez-le ou adaptez votre PATH." -ForegroundColor Red
        return $false
    }
    return $true
}

Write-Host "=== Setup local pour FlashBilan (Windows) ===" -ForegroundColor Green

# Vérifications préalables
$ok = $true
$ok = $ok -and (Check-Tool 'php')
$ok = $ok -and (Check-Tool 'composer')

if ($BuildAssets) {
    $ok = $ok -and (Check-Tool 'node')
    $ok = $ok -and (Check-Tool 'npm')
}

if (-not $ok) {
    Write-Host "Corrigez les outils manquants avant de continuer." -ForegroundColor Red
    exit 1
}

# Composer install
if ($RunAll) {
    if (-not (Test-Path vendor)) {
        Write-Host "Installation des dépendances PHP via Composer..." -ForegroundColor Cyan
        if (-not (Run-Command "composer install --no-interaction --prefer-dist")) { exit 1 }
    } else {
        Write-Host "Dossier vendor déjà présent, exécution de 'composer install' pour actualiser..." -ForegroundColor Cyan
        if (-not (Run-Command "composer install --no-interaction")) { exit 1 }
    }
}

# .env
if (-not (Test-Path .env)) {
    if (Test-Path .env.example) {
        Copy-Item .env.example .env -Force
        Write-Host ".env créé depuis .env.example" -ForegroundColor Green
    } else {
        Write-Host "Aucun .env.example trouvé. Créez manuellement le fichier .env avant de poursuivre." -ForegroundColor Red
    }
}

# Generate key
Write-Host "Génération de APP_KEY (si vide)..." -ForegroundColor Cyan
$envContent = Get-Content .env -ErrorAction SilentlyContinue
if ($envContent -and ($envContent -join "`n") -match 'APP_KEY=') {
    $currentKey = ($envContent | Select-String -Pattern '^APP_KEY=').ToString()
    if ($currentKey -match 'APP_KEY=$' -or $currentKey -match 'APP_KEY=""' -or $currentKey -match 'APP_KEY=base64:') {
        Run-Command "php artisan key:generate"
    } else {
        Write-Host "APP_KEY semble déjà présent." -ForegroundColor Green
    }
} else {
    Run-Command "php artisan key:generate"
}

# Storage link
Write-Host "Création du lien de storage..." -ForegroundColor Cyan
Run-Command "php artisan storage:link"

# Composer dump-autoload
Write-Host "Dump-autoload composer..." -ForegroundColor Cyan
Run-Command "composer dump-autoload -o"

# Clear caches
Write-Host "Vider les caches Laravel (optimize:clear)..." -ForegroundColor Cyan
Run-Command "php artisan optimize:clear"

if (-not $NoCache) {
    Write-Host "Regénération des caches (config/route/view) pour performance (optionnel)." -ForegroundColor Cyan
    Run-Command "php artisan config:cache"
    Run-Command "php artisan route:cache"
    Run-Command "php artisan view:cache"
}

# Migrations (optionnel)
if ($Migrate) {
    Write-Host "Exécution des migrations : php artisan migrate --force" -ForegroundColor Cyan
    if (-not (Run-Command "php artisan migrate --force")) { Write-Host "Migrations échouées." -ForegroundColor Red }
}

# Node / NPM assets
if ($BuildAssets) {
    Write-Host "Installation NPM et build des assets..." -ForegroundColor Cyan
    if (-not (Run-Command "npm install --silent")) { Write-Host "npm install a échoué." -ForegroundColor Red }
    if (-not (Run-Command "npm run build")) { Write-Host "npm run build a échoué." -ForegroundColor Red }
}

Write-Host "=== Opérations terminées. ===" -ForegroundColor Green

Write-Host "Si vous utilisez XAMPP, redémarrez Apache depuis le panneau XAMPP maintenant." -ForegroundColor Yellow
Write-Host "Vous pouvez maintenant vérifier l'application dans le navigateur. Si le widget support ne fonctionne toujours pas, taillez les logs via :" -ForegroundColor Cyan
Write-Host "Get-Content -Path .\storage\logs\laravel.log -Wait -Tail 80" -ForegroundColor Magenta

if ($TailLogs) {
    Write-Host "--- Tailing logs (CTRL+C pour quitter) ---" -ForegroundColor Cyan
    Get-Content -Path .\storage\logs\laravel.log -Wait -Tail 80
}

