#!/usr/bin/env bash
# Deployment helper (remote via SSH)
# Usage:
#   export SSH_USER=deploy
#   export SSH_HOST=example.com
#   export REMOTE_PATH=/var/www/fluxtransfer
#   ./scripts/deploy_remote.sh
#
# This script will: fetch latest git on the server, reset to origin/BRANCH,
# install composer deps, build assets (optional), run migrations (optional),
# clear/cache laravel caches and restart queue workers / php-fpm.
#
# IMPORTANT: Do NOT store private keys here. Configure SSH access on the
# server by adding your public key to ~/.ssh/authorized_keys for the user.

set -euo pipefail

SSH_USER="${SSH_USER:-user}"
SSH_HOST="${SSH_HOST:-example.com}"
SSH_PORT="${SSH_PORT:-22}"
REMOTE_PATH="${REMOTE_PATH:-/var/www/fluxtransfer}"
BRANCH="${BRANCH:-main}"
NO_MIGRATE=${NO_MIGRATE:-0} # set to 1 to skip migrations
BUILD_ASSETS=${BUILD_ASSETS:-0} # set to 1 to run npm build on server

echo "Deploying branch: $BRANCH to $SSH_USER@$SSH_HOST:$REMOTE_PATH"

echo "-- Running remote git fetch && reset --"
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "\
  if [ -d '$REMOTE_PATH' ]; then \
    cd '$REMOTE_PATH' && \
    git fetch --all --prune && \
    git reset --hard origin/$BRANCH && \
    git clean -fd || true; \
  else \
    echo 'Remote path $REMOTE_PATH does not exist'; exit 2; \
  fi
"

echo "-- Installing composer dependencies (remote)"
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "cd '$REMOTE_PATH' && composer install --no-dev --prefer-dist --optimize-autoloader"

if [ "$BUILD_ASSETS" = "1" ]; then
  echo "-- Building assets (remote with npm/yarn)"
  ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "cd '$REMOTE_PATH' && npm ci --silent && npm run build --silent || true"
fi

if [ "$NO_MIGRATE" = "0" ]; then
  echo "-- Running migrations (remote)"
  ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "cd '$REMOTE_PATH' && php artisan migrate --force"
else
  echo "-- Skipping migrations (NO_MIGRATE=1)"
fi

echo "-- Caching configs and restarting services"
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "cd '$REMOTE_PATH' && php artisan config:cache && php artisan route:cache && php artisan view:cache || true"
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "cd '$REMOTE_PATH' && php artisan queue:restart || true"

# Try to restart PHP-FPM (may require sudo on some systems)
echo "-- Trying to reload php-fpm (may require sudo privileges on remote)"
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" bash -lc "sudo systemctl reload php*-fpm || sudo systemctl restart php*-fpm || true"

echo "Deployment finished. Check logs on the server if any step failed."
