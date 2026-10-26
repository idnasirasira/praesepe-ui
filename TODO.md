# Praesepe UI TODOs and placeholders

## Stack versions (logged at bootstrap)

- Laravel Framework: 13.38.0
- PHP: 8.4+ (local CLI 8.4.27)
- Tailwind CSS: 4.x via `@tailwindcss/vite`
- Alpine.js: 3.x with `@alpinejs/focus`
- Pest: 5.x
- Laravel Pint: 1.x
- Larastan: 3.x (PHPStan level 6)
- Playwright + `@axe-core/playwright`: E2E a11y and keyboard suites

## Placeholders (do not invent values)

- [ ] LICENSE copyright holder: replace `TODO: copyright holder year and legal name`
- [x] `config/ui-docs.php` `whatsapp_url`: `https://wa.me/6285117170755` (085117170755)
- [x] `config/ui-docs.php` `email`: `praesepe@idnasirasira.com`
- [x] `config/ui-docs.php` `github_url`: `https://github.com/idnasirasira/praesepe-ui`
- [ ] Brand logo assets: do not invent logos; add SVG or raster assets under `public/` when ready
- [ ] Home page marketing metrics, testimonials, and client names: keep as explicit TODO until real data exists
- [ ] Social proof (star counts, download counts): omit until measurable from a public source

## Launch follow-ups

- [ ] Point DNS for `ui.praesepe.id` and enable HTTPS on the production host
- [ ] Set production `.env` (`APP_URL=https://ui.praesepe.id`, `APP_ENV=production`, `APP_DEBUG=false`)
- [x] Fill `whatsapp_url` in `config/ui-docs.php` (`email` and `github_url` are set)
- [ ] Run `php artisan optimize` on the server after deploy (CI already verifies optimize locally)
- [ ] Publish package distribution strategy (copy-paste docs only vs Composer package)
- [ ] Replace home page marketing TODO with real proof points when available
- [ ] Add real brand logo assets under `public/` when approved
- [x] Wire search "Ask Praesepe to build it" CTA to WhatsApp deep link
