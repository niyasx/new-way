# New Way Consultancy — PHP Website

Production-ready marketing website for **New Way Consultancy** (Perinthalmanna, Kerala). Built with PHP 8.2+, PSR-4 autoloading, and a component-based architecture. The original single-file `index.html` has been refactored into a maintainable application while preserving the full visual design and client-side behavior.

---

## Table of contents

1. [Overview](#overview)
2. [Features](#features)
3. [Requirements](#requirements)
4. [Project structure](#project-structure)
5. [Installation](#installation)
6. [Environment variables](#environment-variables)
7. [Local development](#local-development)
8. [URL routes](#url-routes)
9. [Editing content](#editing-content)
10. [Contact form](#contact-form)
11. [Security](#security)
12. [Frontend assets](#frontend-assets)
13. [SEO and accessibility](#seo-and-accessibility)
14. [Production deployment](#production-deployment)
15. [Troubleshooting](#troubleshooting)
16. [License](#license)

---

## Overview

This application uses a **front controller** pattern: every request is handled by `public/index.php`, which loads configuration, matches a route, and renders a page through layouts and reusable components.

| Layer | Location | Role |
|-------|----------|------|
| Web root | `public/` | Only directory exposed to the internet |
| HTTP layer | `app/Controllers/` | Maps URLs to page responses |
| Presentation | `app/Components/`, `app/Views/` | HTML sections and page templates |
| Business logic | `app/Services/` | CSRF, contact validation, submission |
| Configuration | `config/`, `.env` | Site settings, content data, routes |

**Design principle:** Content lives in `config/content.php`; branding and secrets live in `.env` / `config/app.php`. Views never hardcode phone numbers, emails, or service lists.

---

## Features

- Full landing page at `/` (hero, stats, services, industries, about, process, testimonials, FAQ, contact)
- Dedicated pages: `/about`, `/services`, `/contact`, `/privacy-policy`, `/terms`
- Clean URLs (Apache `mod_rewrite` or Nginx `try_files`)
- CSRF-protected contact form with server-side validation
- FormSubmit.co integration (configurable) with local log fallback
- Security headers (CSP, X-Frame-Options, etc.)
- Open Graph, Twitter Card, and JSON-LD structured data
- Responsive layout matching the original design
- Scroll reveal animations and FAQ accordion (vanilla JS)

---

## Requirements

| Requirement | Notes |
|-------------|--------|
| **PHP** | 8.2 or higher |
| **Composer** | 2.x for dependencies and autoloading |
| **Extensions** | `mbstring`, `json`, `session` (enabled by default on most hosts) |
| **Web server** | Apache + `mod_rewrite`, or Nginx + PHP-FPM |

Optional for production: HTTPS certificate, SMTP or FormSubmit for email delivery.

---

## Project structure

```
new-way/
├── app/
│   ├── Components/          # Reusable UI blocks (hero, services, contact, …)
│   ├── Controllers/         # HomeController, PageController, ContactController
│   ├── Core/                # Application bootstrap, Router
│   ├── Helpers/             # functions.php (e, url, asset, config), ComponentLoader
│   ├── Layouts/             # navigation.php, footer.php
│   ├── Services/            # CsrfService, ContactService
│   └── Views/
│       ├── layouts/         # master.php (HTML shell, meta, assets)
│       └── pages/           # home, about, services, contact, privacy, terms, errors
├── config/
│   ├── app.php              # Site config (reads .env)
│   ├── content.php          # Services, FAQ, testimonials, stats, ticker text
│   └── routes.php           # GET/POST route map
├── public/                  # DOCUMENT ROOT — point your domain here
│   ├── index.php            # Front controller
│   ├── router.php           # Dev server router (see Local development)
│   ├── .htaccess            # Apache rewrite + cache headers
│   └── assets/
│       ├── css/             # site.css (exact original styles), subpages.css
│       ├── js/              # site.js (exact original behavior)
│       └── images/          # og-default.jpg (add for social previews)
├── storage/
│   ├── logs/                # contact.log when remote submit fails
│   └── cache/               # Reserved for future caching
├── vendor/                  # Composer packages (do not edit)
├── .env.example             # Environment template
├── .env                     # Local secrets (create from example; not in git)
├── composer.json
├── composer.lock
├── deploy.md                # Apache, Nginx, cPanel, VPS guides
├── nginx.conf               # Example Nginx server block
└── README.md
```

---

## Installation

### 1. Clone or copy the project

```bash
git clone <repository-url> new-way
cd new-way
```

### 2. Install PHP dependencies

```bash
composer install
```

For production servers:

```bash
composer install --no-dev --optimize-autoloader
```

### 3. Create environment file

```bash
cp .env.example .env
```

Edit `.env` and set at minimum:

- `APP_URL` — full site URL (no trailing slash), e.g. `https://new-way.in`
- `APP_DEBUG` — `false` in production
- `SITE_EMAIL` and phone variables if they differ from defaults

### 4. Set directory permissions

The web server user must write to logs:

```bash
chmod -R 775 storage/logs storage/cache
# On Linux VPS, often:
# chown -R www-data:www-data storage
```

### 5. Configure the web server

**Critical:** The document root must be the `public/` folder, not the project root.

| Server | Document root |
|--------|----------------|
| Apache | `Alias` / `DocumentRoot` → `/path/to/new-way/public` |
| Nginx | `root /path/to/new-way/public;` |
| cPanel | Domain document root → `new-way/public` |

See [deploy.md](deploy.md) for complete Apache, Nginx, shared hosting, and VPS steps.

### 6. Verify installation

- For **local development**, set `APP_URL=http://localhost:8080` in `.env` (canonical/OG URLs only; CSS/JS use root-relative `/assets/...` paths).
- Open `/` — full homepage loads with styles
- Open `/contact` — form displays with CSRF field in HTML source
- Submit a test message (with `APP_DEBUG=true` if debugging)
- Confirm `/assets/css/site.css` returns 200

---

## Environment variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_NAME` | Site / business name | `New Way Consultancy` |
| `APP_ENV` | Environment label | `production` |
| `APP_URL` | Canonical base URL | `https://new-way.in` |
| `APP_DEBUG` | Show PHP errors (`true`/`false`) | `false` |
| `APP_KEY` | Reserved for future encryption | (optional) |
| `SITE_EMAIL` | Primary contact email | `newwaypmna@gmail.com` |
| `SITE_PHONE_PRIMARY` | E.164 or tel link format | `+918086740392` |
| `SITE_PHONE_SECONDARY` | Second phone line | `+917907530899` |
| `MAIL_HOST` | SMTP host (future use) | `smtp.gmail.com` |
| `MAIL_PORT` | SMTP port | `587` |
| `MAIL_USERNAME` | SMTP user | |
| `MAIL_PASSWORD` | SMTP password | |
| `MAIL_FROM_ADDRESS` | From address for mail | |
| `MAIL_FROM_NAME` | From name | |
| `FORM_SUBMIT_ENDPOINT` | FormSubmit AJAX URL | `https://formsubmit.co/ajax/...` |
| `CONTACT_FORM_ENABLED` | Enable/disable submissions | `true` |

Display-friendly phone labels are set in `config/app.php` (`phone_primary_display`, etc.) and can be adjusted there if you prefer not to use env for formatting.

---

## Local development

### PHP built-in server (recommended for quick testing)

```bash
composer install
cp .env.example .env
```

Set in `.env`:

```env
APP_URL=http://localhost:8080
APP_DEBUG=true
```

Start the server **with the router script** so clean URLs work:

```bash
php -S localhost:8080 -t public public/router.php
```

Visit: http://localhost:8080

Without `public/router.php`, paths like `/about` will return 404 on the built-in server.

### Apache locally

Point a vhost `DocumentRoot` to `public/` and ensure `AllowOverride All` so `.htaccess` rewrite rules apply.

### What not to do

- Do not set the document root to the project root (exposes `.env` and `vendor/`)
- Do not commit `.env` to version control
- Do not run `composer.phar` from the repo root in production — install Composer globally or use CI

---

## URL routes

Defined in `config/routes.php`:

| Method | Path | Handler | Description |
|--------|------|---------|-------------|
| GET | `/` | `HomeController@index` | Full single-page landing |
| GET | `/about` | `PageController@about` | About + process + why sections |
| GET | `/services` | `PageController@services` | Services + industries |
| GET | `/contact` | `PageController@contact` | Contact information + form |
| GET | `/privacy-policy` | `PageController@privacy` | Privacy policy |
| GET | `/terms` | `PageController@terms` | Terms of service |
| POST | `/contact/submit` | `ContactController@submit` | JSON API for form (AJAX) |

Navigation on inner pages uses `section_url()` so links like “Services” go to `/#services` from the homepage or `/services` context appropriately.

### Adding a new page

1. Add a route in `config/routes.php`
2. Add a method on `PageController` (or a new controller)
3. Create `app/Views/pages/your-page.php`
4. Reuse components via `ComponentLoader::render('component-name')`

---

## Editing content

### Site-wide text (services, FAQ, testimonials, stats)

Edit **`config/content.php`**. Arrays include:

- `ticker` — scrolling banner items
- `stats`, `hero_panel_stats`
- `services`, `service_options` (form dropdown)
- `about_points`, `process_steps`, `why_cards`
- `testimonials`, `faq`

After changes, refresh the browser; no build step is required.

### Branding, contact info, SEO defaults

Edit **`config/app.php`** or override via **`.env`** (see [Environment variables](#environment-variables)).

### Navigation and footer links

- `app/Layouts/navigation.php`
- `app/Layouts/footer.php`

### Page-specific layout and meta

Controllers pass `pageTitle`, `metaDescription`, and `canonicalUrl` to the master layout. Example in `app/Controllers/PageController.php`.

### HTML structure of a section

Each block lives in `app/Components/` (e.g. `hero.php`, `contact.php`). Change markup there; styles are in `public/assets/css/`.

---

## Contact form

**Flow:**

1. User submits the form on `/` or `/contact`
2. JavaScript (`public/assets/js/forms.js`) validates required fields client-side
3. POST to `/contact/submit` with `FormData` including `_csrf`
4. `ContactController` validates CSRF and input via `ContactService`
5. On success, enquiry is sent to FormSubmit (if configured) or appended to `storage/logs/contact.log`
6. JSON response `{ "success": true }` triggers the success UI

**Fields:** `name` (required), `email` (required), `phone`, `service`, `message` (required), `_honey` (honeypot — must stay empty)

**Disable remote submit:** Set `CONTACT_FORM_ENABLED=false` or clear `FORM_SUBMIT_ENDPOINT`; submissions are logged locally only.

**Fallback:** If the AJAX request fails, the script opens a `mailto:` link with the form data.

---

## Security

| Measure | Implementation |
|---------|----------------|
| Output escaping | `e()` helper → `htmlspecialchars()` |
| CSRF | Session token on all form posts |
| XSS | Escaped output; CSP header in `config/app.php` |
| Spam | Honeypot field `_honey` |
| Input validation | `ContactService::validate()` |
| Headers | X-Frame-Options, X-Content-Type-Options, Referrer-Policy, CSP |
| Document root | Only `public/` is web-accessible |

**Production checklist:**

- `APP_DEBUG=false`
- HTTPS enabled
- Uncomment HTTPS redirect in `public/.htaccess` if using Apache
- Restrict `storage/` from direct HTTP access (it is outside `public/` by default)

---

## Frontend assets

| File | Purpose |
|------|---------|
| `site.css` | Complete stylesheet from the original HTML (unchanged rules) |
| `subpages.css` | Minimal styles for `/about`, `/contact`, etc. only |
| `site.js` | Original inline script (nav, reveal, FAQ, FormSubmit form) |

**Cache busting:** After CSS/JS changes in production, consider versioning in `master.php` (e.g. `site.css?v=2`).

**Important:** Assets use root-relative URLs (`/assets/...`), not `APP_URL`, so the site styles correctly on both `localhost` and production.

**Minification (optional):** See [deploy.md](deploy.md) and minify before deploy; update asset paths in the master layout if you use `.min` files.

**Images:** Add `public/assets/images/og-default.jpg` (1200×630 px) for social sharing. Use `loading="lazy"` on future content images.

---

## SEO and accessibility

- Per-page `<title>`, meta description, canonical URL
- Open Graph and Twitter Card tags in `master.php`
- JSON-LD `EmploymentAgency` schema
- Semantic landmarks: `<main>`, `<nav>`, `<footer>`, headings hierarchy
- Form labels linked with `for` / `id`
- ARIA on navigation toggle, FAQ buttons, WhatsApp float
- `lang="en"` on `<html>`

---

## Production deployment

Full instructions: **[deploy.md](deploy.md)**

Summary:

1. `composer install --no-dev --optimize-autoloader`
2. Copy `.env.example` → `.env` on the server; set production values
3. Point domain document root to **`public/`**
4. Enable HTTPS
5. Verify contact form and check `storage/logs/` if email fails
6. Add `og-default.jpg` under `public/assets/images/`

Example Nginx configuration: **`nginx.conf`** in the project root (adjust paths and PHP-FPM socket).

---

## Troubleshooting

| Problem | Likely cause | Fix |
|---------|----------------|-----|
| 404 on `/about`, `/contact` | Wrong document root or missing rewrite | Use `public/` as root; enable `mod_rewrite` or Nginx `try_files` |
| 404 on dev server only | Built-in server without router | Run `php -S ... public/router.php` |
| Unstyled page | CSS not loading or wrong document root | Open `/assets/css/site.css` directly; document root must be `public/` |
| Form always fails CSRF | Sessions not persisting | Ensure `session` extension enabled; check cookie domain/HTTPS |
| Form submits but no email | FormSubmit or network | Check `storage/logs/contact.log`; verify `FORM_SUBMIT_ENDPOINT` |
| Blank page, PHP error | `APP_DEBUG` off hiding error | Temporarily set `APP_DEBUG=true` in `.env` on staging only |
| `.env` exposed | Document root too high | Must be `public/` only |

**Logs:** Contact failures → `storage/logs/contact.log`  
**PHP errors:** Configure server error log; do not enable `display_errors` in production.

---

## Architecture reference

```
Request → public/index.php
       → load .env + Composer autoload
       → Application::run()
       → Router::match(method, path)
       → Controller action
       → view('pages/...') + Components
       → view('layouts/master', ['content' => ...])
       → HTML response + security headers
```

**Helpers** (`app/Helpers/functions.php`):

- `config('site.email')` — read config
- `config('content.faq')` — read content arrays
- `e($string)` — escape HTML
- `url('/about')` — absolute URL
- `asset('css/site.css')` — root-relative asset path
- `csrf_field()` — hidden input HTML
- `whatsapp_url()` — WhatsApp deep link

---

## License

Proprietary — © New Way Consultancy, Perinthalmanna, Kerala. All rights reserved.

For deployment support, refer to [deploy.md](deploy.md).
