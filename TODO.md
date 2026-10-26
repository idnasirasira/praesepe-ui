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

## Done

- [x] `config/ui-docs.php` contact links (`whatsapp_url`, `email`, `github_url`)
- [x] DNS + HTTPS for `ui.praesepe.id`
- [x] Production `.env` (`APP_URL=https://ui.praesepe.id`, `APP_ENV=production`, `APP_DEBUG=false`)
- [x] Deploy runs `php artisan optimize` (`deploy.local.sh` remote commands)
- [x] Praesepe UI MCP via Laravel MCP (`Mcp::web('/mcp/praesepe-ui')` + local `mcp:start`)
- [x] Document consumer setup (`/docs/mcp`, `mcp/README.md`, copy-paste agent prompt)
- [x] Wire search "Ask Praesepe to build it" CTA to WhatsApp deep link

## Still open (do not invent values)

- [ ] LICENSE copyright holder: replace `TODO: copyright holder year and legal name`
- [ ] Brand logo assets under `public/` when approved (Blade lockups in `x-docs.logo` / `x-docs.praesepe-logo` are interim)
- [ ] Home page marketing metrics, testimonials, and client names (still called out in `home.blade.php`)
- [ ] Social proof (star counts, download counts) until measurable from a public source
- [ ] Publish package distribution strategy (copy-paste docs only vs Composer package)
