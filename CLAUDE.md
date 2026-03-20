# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project context

Migration of **Óptica Andina** (currently on Weebly) to a full Laravel application. The site is an optical shop in Tumbaco/Quito, Ecuador. Core requirements:

- SEO local (Tumbaco/Quito) with Schema.org JSON-LD
- Product catalogue **without prices** — all purchase inquiries go via WhatsApp
- Admin panel (Filament v3) for managing products, services, blog, and settings
- 301 redirects from old Weebly URLs to preserve SEO equity

## Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.2 + Laravel 12 |
| Admin panel | Filament v3 |
| Frontend | Blade + Tailwind CSS 4 + Alpine.js |
| Dynamic components | Livewire 3 |
| Database | MySQL (Laragon) — **change DB_CONNECTION=mysql in .env** |
| Build tool | Vite + @tailwindcss/vite (no tailwind.config.js needed for v4) |
| Image storage | Laravel Storage (public disk) + Intervention Image |

> Note: The plan originally specified Tailwind CSS 3 + tailwind.config.js, but the project was scaffolded with Tailwind CSS 4 (Vite plugin). Stick with v4 — no `tailwind.config.js`, theme customisation goes in `resources/css/app.css` via `@theme {}`.

## Commands

```bash
composer dev          # Start dev environment: serve + queue + pail + npm run dev
npm run build         # Build production assets
composer test         # Clear config cache + run PHPUnit
php artisan test --filter=TestName   # Run single test
./vendor/bin/pint     # Fix PHP code style
php artisan migrate
php artisan migrate:fresh --seed
```

## Packages to install (not yet installed)

```bash
composer require filament/filament:"^3.2" -W
composer require livewire/livewire
composer require spatie/laravel-sitemap
composer require intervention/image
npm install alpinejs
```

## Architecture overview

### URL structure (public routes)

```
GET /                          → HomeController@index
GET /nosotros
GET /contacto + POST /contacto → ContactController (saves ContactMessage, sends mail)
GET /servicios
GET /servicios/{slug}
GET /catalogo                  → Livewire ProductFilter
GET /catalogo/{category}       → Livewire ProductFilter (scoped)
GET /catalogo/{category}/{product}
GET /marcas
GET /marcas/{slug}
GET /blog
GET /blog/{slug}
GET /sitemap.xml
```

Admin panel lives at `/admin` (Filament default).

### Database schema (all migrations pending)

Tables to create, in dependency order:

1. **`site_settings`** — `key` (unique), `value`, `group` (general|seo|contact|social)
2. **`categories`** — `slug`, `parent_id` (self-FK, nullable), `sort_order`, `is_active`, SEO fields
3. **`brands`** — `slug`, `logo`, `country`, `is_active`
4. **`products`** — `category_id`, `brand_id` (nullable), `slug`, `attributes` (JSON), `is_available`, `is_featured`, `whatsapp_text`, SEO fields
5. **`product_images`** — `product_id`, `path`, `alt`, `sort_order`, `is_cover`
6. **`services`** — `slug`, `content` (longtext), `faqs` (JSON: `[{question, answer}]`), `cta_whatsapp_text`, SEO fields
7. **`blog_posts`** — `slug`, `content`, `tags` (JSON), `reading_time`, `is_published`, `published_at`, SEO fields
8. **`contact_messages`** — `name`, `email`, `phone`, `subject`, `message`, `is_read`
9. **`redirects`** — `from_path` (unique), `to_path`, `code` (301/302), `is_active`
10. **`seo_metas`** — `page_key` (unique: home|nosotros|servicios|catalogo|blog|contacto), OG fields, `canonical`, `noindex`

### Key models and patterns

- `SiteSetting::get(string $key, $default = null)` — cached key-value config
- `SeoMeta::getForPage(string $key)` — per-page SEO data
- `Product` scopes: `active()`, `featured()`; accessor: `coverImage`, `whatsappUrl`
- `Category` scopes: `active()`, `root()` (no parent); relation: `children()`
- `BlogPost` scopes: `published()`

### Key services and middleware

- `app/Services/SeoService.php` — builds meta array for any entity/page
- `app/View/Components/SeoMeta.php` + `seo-meta.blade.php` — renders `<title>`, `<meta>`, OG, JSON-LD in `<head>`
- `app/Http/Middleware/HandleRedirects.php` — reads `redirects` table (cached), issues 301/302; register as global web middleware in `bootstrap/app.php`

### View structure

```
resources/views/
├── layouts/app.blade.php          ← main layout: <x-seo-meta>, header, footer, sticky WhatsApp btn
├── components/
│   ├── header.blade.php
│   ├── footer.blade.php
│   ├── whatsapp-button.blade.php  ← floating fixed button + per-product/service variant
│   ├── seo-meta.blade.php
│   ├── product-card.blade.php
│   ├── service-card.blade.php
│   └── breadcrumb.blade.php
├── pages/
│   ├── home.blade.php
│   ├── nosotros.blade.php
│   ├── contacto.blade.php         ← <livewire:contact-form>
│   ├── servicios/index + show     ← show has FAQs accordion + CTA WhatsApp
│   ├── catalogo/index + category + product  ← index/category use <livewire:product-filter>
│   ├── marcas/index + show
│   └── blog/index + post
└── livewire/
    ├── product-filter.blade.php   ← grid with skeleton loading
    └── contact-form.blade.php
```

### Filament admin resources

`ProductResource`, `CategoryResource`, `BrandResource`, `ServiceResource`, `BlogPostResource`, `ContactMessageResource` (read-only), `RedirectResource`, `SeoMetaResource`, plus `ManageSettings` page for `site_settings`.

### WhatsApp integration

Number stored in `site_settings.whatsapp_number`. URL format: `https://wa.me/{number}?text={urlencode(text)}`

- Floating button: generic configurable message
- Product page: `"Hola, me interesa el producto: {name} ({category}). ¿Podría darme más información?"`
- Service page: `"Hola, quisiera información sobre el servicio: {title}. ¿Cuándo puedo agendar una cita?"`

### SEO / Schema.org

Each page type has a JSON-LD schema:
- Home → `LocalBusiness` (address: Tumbaco, openingHours, geo)
- Product → `Product` (name, brand, image, availability)
- Service → `Service` + `FAQPage`
- Blog post → `Article`
- Contact → `ContactPage`

Sitemap via `spatie/laravel-sitemap` with priorities: static pages 1.0 → services 0.9 → categories 0.8 → products 0.7 → blog 0.6.

### Weebly redirect map (seed into `redirects` table)

```
/contaacutectanos.html                                    → /contacto
/examenes.html                                           → /servicios/examen-visual-integral
/nuestros-servicios.html                                 → /servicios
/consejos-de-salud-visual.html                           → /blog
/store/c3/Lentes_de_Hombre.html                         → /catalogo/lentes-hombre
/store/c4/Lentes_de_Mujer.html                          → /catalogo/lentes-mujer
/gafas-de-sol.html                                       → /catalogo/gafas-sol
/lentes-deportivos1.html                                 → /catalogo/lentes-deportivos
/lentes-de-contacto-y-lentes-oftaacutelmicas.html       → /catalogo/lentes-contacto
```

### Initial seeders

`SiteSettingSeeder` (business name, Tumbaco address, phone, WhatsApp number), `CategorySeeder` (6 categories: lentes hombre/mujer/infantil, gafas sol, deportivos, lentes contacto), `ServiceSeeder` (7 services including examen visual, contactología, terapia visual), `RedirectSeeder`, `SeoMetaSeeder`.

## Implementation order

1. Install missing packages (Filament, Livewire, spatie/sitemap, Intervention Image, Alpine.js)
2. Switch `.env` to MySQL, create `opticaandina` database (utf8mb4)
3. Create all migrations in schema order above
4. Create models with relationships and scopes
5. Run seeders (settings, categories, services, redirects)
6. Build Filament resources + ManageSettings page
7. Register `HandleRedirects` middleware globally
8. Create layout + Blade components (header, footer, whatsapp-button, seo-meta)
9. Build public pages: home → servicios → catálogo (Livewire) → blog → contacto → nosotros → marcas
10. Implement SeoService, Schema JSON-LD per type, SitemapController, robots.txt
