# Óptica Vista Andina — Laravel Web Application

A full-stack web application built for a brick-and-mortar optical shop in Tumbaco, Ecuador. Replaces a legacy Weebly site with a professional, SEO-optimized, and fully manageable Laravel platform.

---

## Overview

Óptica Vista Andina is a content-driven business website for a local optical shop that offers prescription lenses, contact lenses, sports eyewear, sunglasses, and vision care services. The previous Weebly-based site offered no CMS flexibility, poor local SEO, and no structured product catalog.

This application solves those problems by providing:

- A structured product catalog organized by category and brand, with WhatsApp-based inquiry flow (no e-commerce checkout required).
- A full admin panel for managing all site content — products, services, blog posts, redirects, and SEO metadata — without touching code.
- Local SEO infrastructure built into every page type, including Schema.org JSON-LD, Open Graph metadata, canonical URLs, and an auto-generated sitemap.
- A clean migration path from Weebly via 301 redirect rules seeded from the old URL structure, preserving existing SEO equity.

**Target users:** The shop owner and staff (admin panel) and local customers searching for optical services in Tumbaco and Quito (public site).

---

## Key Features

- Product catalog with category and brand filtering via a reactive Livewire component (URL-bound state, no full page reloads)
- WhatsApp CTA integration on every product and service page with pre-filled, context-aware message templates
- Filament v3 admin panel with resources for products, categories, brands, services, blog posts, contact messages, redirects, SEO metadata, stats, testimonials, FAQs, and appointments
- Per-page SEO management: title, meta description, Open Graph, canonical URL, noindex flag — all editable from the admin panel
- Schema.org JSON-LD structured data for LocalBusiness, Product, Service, FAQPage, and Article types
- Blog with published/draft workflow and reading time metadata
- Contact form with database-persisted messages and admin read/unread tracking
- Appointment booking form (Livewire component)
- Automated XML sitemap via `spatie/laravel-sitemap`
- 301/302 redirect middleware backed by a database table, with cache auto-invalidation on change
- `robots.txt` with sitemap reference
- Performance-optimized: file-based cache and session drivers, fulltext search index on product names, single-query settings loader cached indefinitely

---

## Tech Stack

**Backend**
- PHP 8.2 / Laravel 12
- Livewire 3 (reactive components without writing JavaScript)
- Filament v3 (admin panel)
- Intervention Image v3 (image processing)
- Spatie Laravel Sitemap v8

**Frontend**
- Blade (templating)
- Alpine.js v3 (lightweight interactivity)
- Tailwind CSS v4 (utility-first, configured via `@theme {}` in CSS — no `tailwind.config.js`)

**Database**
- MySQL 8 with fulltext and composite indexes for performance

**Tooling**
- Vite 7 with `@tailwindcss/vite` plugin
- Laravel Pint (code style)
- PHPUnit 11 (testing)
- Laravel Pail (log tailing in development)

---

## My Role

This project was designed and built end-to-end as a solo full-stack engagement.

**Architecture:** Designed the database schema from scratch — 10 custom tables in dependency order, with self-referencing categories, JSON columns for product attributes and FAQ data, and a key-value settings table with a group-based organization pattern.

**Backend:** Implemented all models with scopes (`active()`, `featured()`, `published()`, `root()`), accessors (`coverImage`, `whatsappUrl`), and relationships. Built `SeoService` as a centralized meta-array builder consumed by every page type. Implemented `HandleRedirects` middleware registered globally, reading from a cached database table with automatic invalidation via model boot events.

**Admin panel:** Configured 11 Filament resources covering the full content model of the site, plus a custom `ManageSettings` page for key-value site configuration with grouped tabs.

**Frontend:** Built the full Blade view hierarchy — main layout, 12 public pages, and reusable components (header, footer, WhatsApp button, product card, service card, breadcrumb, SEO meta). Integrated Alpine.js for accordions, navigation state, and interactive UI elements.

**Livewire:** Built the `ProductFilter` component with URL-bound category, brand, and search filters. Search uses `whereFullText()` for terms of 3+ characters, falling back to `LIKE` for shorter queries.

**SEO:** Implemented Schema.org JSON-LD for five page types. Configured Open Graph metadata, canonical URLs, and per-page noindex control. Generated the sitemap with priority tiers by content type. Preserved Weebly URL equity via seeded 301 redirects.

**Performance:** Applied targeted optimizations — switched cache and session to file drivers, unified the settings loader to a single cached query, added database indexes (fulltext + composite), and deferred third-party scripts to the `window load` event.

---

## Screenshots

![Homepage — hero section and featured services](./docs/images/homepage.png)

![Product catalog with Livewire filtering](./docs/images/catalogo.png)

![Service detail page with FAQ accordion and WhatsApp CTA](./docs/images/servicio-detail.png)

![Filament admin panel — product management](./docs/images/admin-panel.png)

---

## Local Setup

**Requirements:** PHP 8.2+, Composer, Node.js 18+, MySQL 8, Laragon or equivalent local environment.

```bash
# 1. Clone the repository
git clone https://github.com/your-username/opticaandina.git
cd opticaandina

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Create the database
# Create a MySQL database named `opticaandina`, then update .env:
# DB_CONNECTION=mysql
# DB_DATABASE=opticaandina
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Run migrations and seed data
php artisan migrate --seed

# 7. Link storage
php artisan storage:link

# 8. Start the development environment (serves + queue + logs + Vite)
composer dev
```

The application will be available at `http://localhost:8000` (or `http://opticaandina.test` if using Laragon with a custom host).

The Filament admin panel is at `/admin`. Create an admin user with:

```bash
php artisan make:filament-user
```

---

## Technical Highlights

**Centralized SEO service.** `SeoService` provides a consistent meta-array interface (`forPage()`, `forProduct()`, `forService()`, `forBlogPost()`) used across all controllers and rendered by a single `<x-seo-meta>` Blade component. Structured data (JSON-LD) is composed per entity type and injected into the `<head>` without duplicating logic.

**Cached redirect middleware.** `HandleRedirects` reads all active redirects from the database once, caches the result indefinitely under a known key, and serves responses before any controller is reached. The `Redirect` model's `booted()` method invalidates this cache automatically on any create, update, or delete — zero manual cache management required.

**Unified settings loader.** `SiteSetting::getAll()` executes a single database query and caches the entire key-value map. All subsequent `SiteSetting::get($key)` calls hit only the in-memory array. The Filament settings page calls `SiteSetting::flushCache()` on save, which clears exactly one cache key.

**URL-bound Livewire filter.** `ProductFilter` uses `#[Url]` attributes on its filter properties, making filter state bookmarkable and shareable. Brand name resolution for display uses `collect()->firstWhere()` against the pre-loaded brands array — no additional query per render.

**Fulltext search with graceful fallback.** Product search uses MySQL's `MATCH ... AGAINST` via `whereFullText()` for terms of 3 or more characters, benefiting from the `ft_products_name` fulltext index. Shorter terms fall back to a `LIKE` query to avoid MySQL fulltext minimum-word-length restrictions.

**Tailwind CSS v4 without config file.** The project uses the `@tailwindcss/vite` plugin with all theme customization declared inside `@theme {}` blocks in `resources/css/app.css`, consistent with the v4 approach of treating CSS as the source of truth for design tokens.

**Schema.org coverage.** Five JSON-LD schema types are implemented — `LocalBusiness` (home), `Product` (catalog), `Service` + `FAQPage` (services), and `Article` (blog). All structured data is rendered server-side and validated against the relevant schema specifications.

---

## Future Improvements

- Google Maps embed on the contact page once GPS coordinates are confirmed
- Enhanced Filament table filters, bulk actions, and export for products and blog posts
- Image optimization pipeline (WebP conversion, responsive `srcset`) via Intervention Image on upload
- Customer-facing appointment booking with calendar availability display
- Integration with a transactional email provider (Resend or Postmark) for contact form confirmations
- Automated PHPUnit test coverage for controllers, middleware, and Livewire components

---

## Notes

This project reflects the kind of work involved in replacing a template-based site builder with a maintainable, scalable application — including decisions around schema design, content management, SEO infrastructure, and long-term operability for a non-technical owner. Every public-facing URL is independently SEO-configurable from the admin panel without developer intervention.
