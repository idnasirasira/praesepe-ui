# Praesepe UI TODOs and placeholders

## Stack versions (logged at bootstrap)

- Laravel Framework: 13.38.0
- PHP: 8.3+ (local CLI 8.4.27)
- Tailwind CSS: 4.x via `@tailwindcss/vite`
- Alpine.js: 3.x with `@alpinejs/focus`
- Pest: 5.x
- Laravel Pint: 1.x
- Larastan: 3.x (PHPStan level 6)
- Playwright + `@axe-core/playwright`: E2E a11y and keyboard suites

## Placeholders (do not invent values)

- [ ] LICENSE copyright holder: replace `TODO: copyright holder year and legal name`
- [ ] `config/ui-docs.php` `whatsapp_url`: replace with real WhatsApp deep link when available
- [ ] `config/ui-docs.php` `email`: replace with real studio contact email
- [ ] `config/ui-docs.php` `github_url`: replace with real GitHub organization or repository URL
- [ ] Brand logo assets: do not invent logos; add SVG or raster assets under `public/` when ready
- [ ] Home page marketing metrics, testimonials, and client names: keep as explicit TODO until real data exists
- [ ] Social proof (star counts, download counts): omit until measurable from a public source

## Launch follow-ups

- [ ] Point DNS for `ui.praesepe.id` and enable HTTPS on the production host
- [ ] Set production `.env` (`APP_URL=https://ui.praesepe.id`, `APP_ENV=production`, `APP_DEBUG=false`)
- [ ] Fill `whatsapp_url`, `email`, and `github_url` in `config/ui-docs.php` (or env-backed config) before marketing blasts
- [ ] Run `php artisan optimize` on the server after deploy (CI already verifies optimize locally)
- [ ] Publish package distribution strategy (copy-paste docs only vs Composer package)
- [ ] Replace home page marketing TODO with real proof points when available
- [ ] Add real brand logo assets under `public/` when approved
- [ ] Optional: wire search "Ask Praesepe to build it" CTA exclusively to WhatsApp once the deep link exists
