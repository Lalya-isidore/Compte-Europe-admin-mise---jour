DEPLOY.md

But: Checklist and steps to ensure images (and overall app) work when deploying to production

1) Environment
- Set `APP_ENV=production`, `APP_DEBUG=false` in `.env` on the production server.
- Set `APP_URL` to your production URL (e.g. `https://easytransferflux.world`).
- Ensure `APP_KEY` is set (copy from local only if you want the same encryption key; otherwise generate a new key and update other services accordingly).
- Configure database variables: `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Choose filesystem disk:
  - For local storage: `FILESYSTEM_DISK=public`
  - For S3: `FILESYSTEM_DISK=s3` + configure AWS keys in .env and `config/filesystems.php`.

2) Public storage (images)
- Ensure uploads go to `storage/app/public` (application uses `Storage::disk('public')`).
- Create the public link so files are served from `/storage/...`:
  - From the directory containing `artisan` run: `php artisan storage:link`
  - If `php artisan storage:link` is not possible on your host, create a symlink manually:
    - Linux: `ln -s /full/path/to/project/storage/app/public /full/path/to/project/public/storage`
    - If symlink creation is not allowed, copy files (fallback): `rsync -av --delete storage/app/public/ public/storage/`
- Verify that image paths stored in DB are relative, e.g. `comptes-photos/compte_xxx.jpg` (no leading slash).
- Use `Storage::disk('public')->url($path)` or `asset('storage/'.$path)` in views.

3) Permissions & web server
- Give the web server read access to `storage` and `public/storage` (owner/group depend on host):
  - Example: `sudo chown -R www-data:www-data storage public/storage` and `chmod -R 755 storage public/storage`.
- Ensure web server follows symlinks and serves the `storage` folder (Apache `FollowSymLinks`, or Nginx `alias` configuration if needed).

4) Caches & config
- After changing `.env` or config run:
  - `php artisan config:clear`
  - `php artisan cache:clear`
  - `php artisan route:clear`
  - `php artisan view:clear`
  - Optionally: `php artisan config:cache` and `php artisan route:cache` for performance.

5) Assets
- Build frontend assets: `npm ci && npm run build` or `yarn && yarn build` if using Vite.
- Upload files in `public` / built assets to server.

6) Test
- Verify direct access to an image:
  - `curl -I https://yourdomain.tld/storage/comptes-photos/compte_xxx.jpg` should return `200 OK`.
- Open the page in a browser and check DevTools Network tab for `404/403` on image requests.

7) Automate
- Add steps in your deploy script or CI pipeline:
  - `composer install --no-dev --optimize-autoloader`
  - `php artisan migrate --force`
  - `php artisan storage:link || ln -s ...` (fallback)
  - `php artisan config:cache` / `route:cache` / `view:cache`
  - Set permissions

8) Backup and rollback
- Backup DB and `storage` before deploying changes that affect file locations.

9) Advanced: use S3 + CDN
- For reliability and scale, configure `FILESYSTEM_DISK=s3` and serve via CloudFront or another CDN. This avoids symlink/permission issues and speeds up image delivery.

Notes specific to this repository
- There's a `scripts/deploy_prepare.sh` that will attempt to run `php artisan storage:link`, create a symlink fallback, set conservative permissions and clear caches. Run it from your project root (or where `artisan` lives).

If you want, I can:
- Produce a one-line SSH command that runs the `deploy_prepare.sh` on your server (pasteable), or
- Walk you step-by-step while you run the commands on the server and paste outputs here for troubleshooting.