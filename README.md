# Æther Marketing Agency (Laravel)

Custom remake of the WordPress marketing site — public one-pager + admin portfolio CRUD.

## Local (XAMPP)

1. Ensure Apache + MySQL are running.
2. Database `aether_app` (already used by `.env`).
3. From this folder:

```bash
composer install
cp .env.example .env   # if needed; then set DB_*, APP_URL and ADMIN_*
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
```

4. Open:

- Site: http://localhost/aether-app/public  
  (or http://localhost/aether-app if root `.htaccess` rewrite works)
- Admin login: http://localhost/aether-app/public/login  

**First admin account**

The seeder creates one admin from `ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env`.
If `ADMIN_PASSWORD` is empty, a random password is generated and printed once in the
terminal. Re-running the seeder never changes an existing admin's password.

> ⚠️ `APP_URL` in `.env` must match the exact public URL (scheme, host, port and path).
> All CSS, JS, images and links are built from it, so a wrong value makes the site
> load unstyled with broken images. Example:
>
> ```
> APP_URL=http://localhost/aether-app/public
> ```
>
> Run `php artisan config:clear` (or `config:cache` on production) after changing it.

## cPanel deploy

1. Upload the project **outside** `public_html` (e.g. `~/aether-app`), then point the domain / subdomain
   document root to its `public` directory (cPanel → Domains → Document Root).
   Do **not** rely on uploading the whole project into `public_html`: the root `.htaccess` blocks `.env`,
   `vendor/`, `storage/` etc. as a safety net, but pointing the document root at `public/` is the only
   setup where those files are never web-reachable.
2. Create a MySQL database + user in cPanel; put credentials in `.env`.
3. Set `APP_ENV=production`, `APP_DEBUG=false`, and a correct `APP_URL=https://your-domain.com`
   (see the `APP_URL` warning above).
4. Set up email so contact form messages reach you: create a mailbox in cPanel, then set
   `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT` (465 + `MAIL_SCHEME=smtps`, or 587),
   `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, and `CONTACT_NOTIFY_EMAIL`
   (comma-separate several addresses). Messages are always saved in the admin too.
5. Set `ADMIN_EMAIL` and a strong `ADMIN_PASSWORD` before seeding.
6. SSH (recommended):

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
npm ci && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

7. Ensure `storage/` and `bootstrap/cache/` are writable.
8. Seed once to create the admin and starter projects (safe to re-run; it won't reset the admin password):

```bash
php artisan db:seed --force
```

If the host has no SSH Node, build assets locally (`npm run build`) and upload `public/build`.

## What is included (v1)

- Public home: hero, features, services, about, portfolio, contact
- Portfolio detail pages from DB
- Admin: dashboard, projects CRUD (cover upload), contact messages
- Contact form: email notification, honeypot + rate limiting (3/min, 10/hour per IP)
- Brand assets copied from the old WP uploads

## Out of scope (later)

- Kanban / Trello UI
- Blog / multilingual
