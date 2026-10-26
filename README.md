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

## Philosophy

- Stateless docs routes: no database queries for documentation pages
- Semantic CSS tokens (`--ui-*`) so themes and dark mode swap at runtime
- Components are copy-paste friendly Blade + Alpine, not a heavy runtime package
- Architected with WCAG 2.2 AA patterns in mind (keyboard and ARIA documented per component)

## License

MIT. See `LICENSE`. Copyright holder is marked TODO until finalized.
