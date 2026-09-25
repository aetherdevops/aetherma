# Æther Marketing Agency (Laravel)

Custom remake of the WordPress marketing site — public one-pager + admin portfolio CRUD.

## Local (XAMPP)

1. Ensure Apache + MySQL are running.
2. Database `aether_app` (already used by `.env`).
3. From this folder:

```bash
composer install
cp .env.example .env   # if needed; then set DB_* and APP_URL
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

**Default admin**

- Email: `admin@aether.local`
- Password: `password`

Change the password after first login.

`APP_URL` in `.env` must match the public URL, e.g.:

```
APP_URL=http://localhost/aether-app/public
```

## cPanel deploy

1. Upload the project **outside** `public_html` (or into a subfolder), then point the domain / subdomain document root to the Laravel `public` directory.
2. Create a MySQL database + user in cPanel; put credentials in `.env`.
3. Set `APP_ENV=production`, `APP_DEBUG=false`, and a correct `APP_URL=https://your-domain.com`.
4. SSH (recommended):

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

5. Ensure `storage/` and `bootstrap/cache/` are writable.
6. Seed once if you want the starter projects/admin:

```bash
php artisan db:seed --force
```

If the host has no SSH Node, build assets locally (`npm run build`) and upload `public/build`.

## What is included (v1)

- Public home: hero, features, services, about, portfolio, contact
- Portfolio detail pages from DB
- Admin: dashboard, projects CRUD (cover upload), contact messages
- Brand assets copied from the old WP uploads

## Out of scope (later)

- Kanban / Trello UI
- Blog / multilingual
