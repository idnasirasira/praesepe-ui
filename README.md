# Praesepe UI

Open-source (MIT) copy-paste component library for Laravel Blade developers using
Tailwind CSS 4 and Alpine.js 3.

This repository is the dogfooded documentation and showcase application for
[ui.praesepe.id](https://ui.praesepe.id). It is also a portfolio and lead-generation
asset for [Praesepe](https://praesepe.id), a software studio building custom
software for SMEs.

## Stack

- Laravel 13
- PHP 8.3+
- Tailwind CSS 4 (`@tailwindcss/vite`)
- Alpine.js 3 with `@alpinejs/focus`
- Pest, Pint, Larastan (level 6)

## Quick start

```bash
composer setup
composer run dev
```

Visit the local app URL printed by Herd, Sail, or `php artisan serve`.

## Scripts

| Script | Purpose |
| --- | --- |
| `composer lint` | Style check (Pint) |
| `composer format` | Auto-format PHP |
| `composer analyse` | Static analysis (Larastan level 6) |
| `composer test` | Pest suite |
| `composer check` | lint + analyse + test |
| `npm run build` | Production Vite build |
| `npm run dev` | Vite development server |
| `npm run test:e2e` | Playwright a11y + keyboard interaction suite |
| `npm run test:e2e:a11y` | Axe WCAG 2.2 AA scan across themes and modes |
| `npm run test:e2e:interactions` | Modal, dropdown, tabs, and search keyboard flows |

### End-to-end accessibility and keyboard tests

Install browser binaries once, build assets, then run Playwright (it starts `php artisan serve` automatically):

```bash
npx playwright install chromium
npm run build
npm run test:e2e
```

Run only Axe or only interaction specs:

```bash
npm run test:e2e:a11y
npm run test:e2e:interactions
```

Optional UI mode: `npm run test:e2e:ui`. Override the base URL with `PLAYWRIGHT_BASE_URL` when the app is already running.

## Philosophy

- Stateless docs routes: no database queries for documentation pages
- Semantic CSS tokens (`--ui-*`) so themes and dark mode swap at runtime
- Components are copy-paste friendly Blade + Alpine, not a heavy runtime package
- Architected with WCAG 2.2 AA patterns in mind (keyboard and ARIA documented per component)

## License

MIT. See `LICENSE`. Copyright holder is marked TODO until finalized.
