# Deployment Guide — New Way Consultancy

## Pre-deploy Checklist

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Run `composer install --no-dev --optimize-autoloader`
3. Ensure `storage/logs` and `storage/cache` are writable by the web server user
4. Point the **document root** to the `public/` directory (never the project root)
5. Enable HTTPS and uncomment HTTPS redirect in `public/.htaccess` if using Apache

## Apache (Shared Hosting / VPS)

1. Upload the project (exclude `.git` if desired).
2. Set the virtual host `DocumentRoot` to `/path/to/new-way/public`.
3. Enable `mod_rewrite`.
4. Ensure `AllowOverride All` for the public directory so `.htaccess` works.
5. PHP 8.2+ via `AddHandler` or FPM pool.

Example virtual host snippet:

```apache
<VirtualHost *:443>
    ServerName new-way.in
    DocumentRoot /var/www/new-way/public

    <Directory /var/www/new-way/public>
        AllowOverride All
        Require all granted
    </Directory>

    SSLEngine on
    # SSLCertificateFile / SSLCertificateKeyFile ...
</VirtualHost>
```

## Nginx (VPS)

1. Copy `nginx.conf` to `/etc/nginx/sites-available/new-way`
2. Adjust `root`, `server_name`, and `fastcgi_pass` socket
3. `ln -s` to sites-enabled and `nginx -t && systemctl reload nginx`

## Shared Hosting (cPanel)

1. Upload files via FTP/Git to `home/user/new-way`
2. In cPanel → Domains → set document root to `new-way/public`
3. Select PHP 8.2+
4. Create `.env` from `.env.example` in project root (above `public`)
5. If Composer is unavailable locally, run `composer install` on your machine and upload the `vendor/` folder

## VPS (Ubuntu-style)

```bash
sudo apt update
sudo apt install nginx php8.2-fpm php8.2-mbstring composer
cd /var/www
git clone <repo> new-way
cd new-way
composer install --no-dev
cp .env.example .env
sudo chown -R www-data:www-data storage
# Configure nginx using nginx.conf
sudo ln -s /etc/nginx/sites-available/new-way /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

## Environment Variables (Production)

| Variable | Example |
|----------|---------|
| `APP_URL` | `https://new-way.in` |
| `APP_DEBUG` | `false` |
| `SITE_EMAIL` | `newwaypmna@gmail.com` |
| `FORM_SUBMIT_ENDPOINT` | FormSubmit AJAX URL |

## Caching Strategy

- **Browser**: Static assets cached 1 year via `.htaccess` / Nginx `expires`
- **Server**: Optional OPcache for PHP; no application cache required for this site
- **Images**: Prefer WebP with `<picture>` fallbacks when adding photos to `public/assets/images/`

## Image Optimization Recommendations

- Add `og-default.jpg` (1200×630) at `public/assets/images/og-default.jpg`
- Use `loading="lazy"` on content images
- Serve WebP with JPEG/PNG fallback for hero or gallery images

## Post-deploy Verification

- [ ] Home page loads with correct styles and scripts
- [ ] Contact form submits (check `storage/logs/contact.log` on failure)
- [ ] `/privacy-policy` and `/terms` accessible
- [ ] HTTPS redirect works
- [ ] No access to `/vendor` or `/.env` via browser

## Rollback

Keep the previous release directory. Swap the symlink or document root back to the prior version and reload the web server.
