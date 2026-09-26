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

## Site content settings

Contact details, social links and analytics live in `.env` (see `config/site.php`).
Anything left empty is hidden, so the site never shows placeholder details:

| Variable | Shown as |
| --- | --- |
| `SITE_EMAIL`, `SITE_PHONE`, `SITE_LOCATION` | Contact section, footer, Google structured data |
| `SITE_MAP_URL` | Makes the location a Google Maps link |
| `SITE_BOOKING_URL` | "Book a free call" buttons (Calendly etc.) |
| `SOCIAL_INSTAGRAM`, `SOCIAL_LINKEDIN`, `SOCIAL_FACEBOOK`, `SOCIAL_TIKTOK`, `SOCIAL_BEHANCE` | Footer links + structured data |
| `ANALYTICS_PLAUSIBLE_DOMAIN` | Cookieless analytics (no banner needed) |
| `ANALYTICS_GA4_ID` | Google Analytics 4, loaded only after cookie consent; the banner appears automatically |

Run `php artisan config:cache` after changing `.env` on production.

The privacy page (`/privacy`) adapts to these settings, but have it reviewed for your
jurisdiction before launch, and update `SITE_PRIVACY_UPDATED` when you change it.

## Uploads

Project covers go up to 5 MB and gallery files (images, MP4/WebM) up to 20 MB each. Many
cPanel hosts default PHP to 2 MB uploads, so raise these in cPanel → *MultiPHP INI Editor*:
`upload_max_filesize = 24M`, `post_max_size = 128M`. Export images around 1600px wide (WebP
or JPG) to keep pages fast.

## What is included

- Public home: hero, services, about, portfolio, testimonials (shown once one is published), contact
- Portfolio detail pages with gallery (images + video) and previous/next navigation
- SEO: meta description, canonical, Open Graph / X cards, JSON-LD, `/sitemap.xml`, `/robots.txt`
  (outside production robots.txt blocks all crawlers so staging copies aren't indexed)
- Privacy & cookies page, optional analytics with consent banner
- Admin: dashboard, projects (rich-text editor, cover, gallery, one-click publish), testimonials,
  contact inbox (unread/read, reply by email), account settings
- Contact form: email notification, honeypot + rate limiting (3/min, 10/hour per IP)
- Project descriptions are sanitized (on save and on display), so pasted scripts never run
- Self-hosted fonts, long-lived caching for built assets, basic security headers (`public/.htaccess`)

## Out of scope (later)

- Kanban / Trello UI
- Blog / multilingual
