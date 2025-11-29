<#
PowerShell deployment helper (remote via SSH)
Usage (PowerShell):
  $env:SSH_USER = 'deploy'
  $env:SSH_HOST = 'example.com'
  $env:REMOTE_PATH = '/var/www/fluxtransfer'
  ./scripts/deploy_remote.ps1

This script uses the native OpenSSH `ssh` command available on modern Windows.
Do not store private keys in the repo. Install your public key on the server
in ~/.ssh/authorized_keys for the deploy user.
#>
param()

$SSH_USER = $env:SSH_USER -or 'user'
$SSH_HOST = $env:SSH_HOST -or 'example.com'
$SSH_PORT = $env:SSH_PORT -or '22'
$REMOTE_PATH = $env:REMOTE_PATH -or '/var/www/fluxtransfer'
$BRANCH = $env:BRANCH -or 'main'
$NO_MIGRATE = $env:NO_MIGRATE -or '0'
$BUILD_ASSETS = $env:BUILD_ASSETS -or '0'

Write-Host "Deploying branch: $BRANCH to $SSH_USER@$SSH_HOST:$REMOTE_PATH"

$ssh = "ssh -p $SSH_PORT $SSH_USER@$SSH_HOST"

Write-Host "-- Running remote git fetch and reset"
& bash -c "$ssh \"if [ -d '$REMOTE_PATH' ]; then cd '$REMOTE_PATH' && git fetch --all --prune && git reset --hard origin/$BRANCH && git clean -fd || true; else echo 'Remote path $REMOTE_PATH does not exist'; exit 2; fi\""

Write-Host "-- Installing composer dependencies (remote)"
& bash -c "$ssh \"cd '$REMOTE_PATH' && composer install --no-dev --prefer-dist --optimize-autoloader\""

if ($BUILD_ASSETS -eq '1') {
    Write-Host "-- Building assets (remote with npm/yarn)"
    & bash -c "$ssh \"cd '$REMOTE_PATH' && npm ci --silent && npm run build --silent || true\""
}

if ($NO_MIGRATE -eq '0') {
    Write-Host "-- Running migrations (remote)"
    & bash -c "$ssh \"cd '$REMOTE_PATH' && php artisan migrate --force\""
} else {
    Write-Host "-- Skipping migrations (NO_MIGRATE=1)"
}

Write-Host "-- Caching configs and restarting services"
& bash -c "$ssh \"cd '$REMOTE_PATH' && php artisan config:cache && php artisan route:cache && php artisan view:cache || true\""
& bash -c "$ssh \"cd '$REMOTE_PATH' && php artisan queue:restart || true\""

Write-Host "-- Trying to reload php-fpm on remote (may require sudo)"
& bash -c "$ssh \"sudo systemctl reload php*-fpm || sudo systemctl restart php*-fpm || true\""

Write-Host "Deployment finished."
