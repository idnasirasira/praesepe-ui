# Contributing to Praesepe UI

Thank you for helping improve Praesepe UI. This document explains how to develop,
test, and submit changes.

## Prerequisites

- PHP 8.3 or newer
- Composer 2
- Node.js 20 or newer and npm
- SQLite (default local database) or another driver configured in `.env`

## Setup

```bash
composer setup
```

Or manually:

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

## Quality checks

Run these before every pull request:

```bash
composer check
npm run build
npm run test:e2e
```

Individual scripts:

- `composer lint` : Pint style check (`pint --test`)
- `composer format` : auto-fix style with Pint
- `composer analyse` : Larastan / PHPStan level 6
- `composer test` : Pest test suite
- `npm run test:e2e` : Playwright Axe a11y + keyboard interaction suite
- `npm run test:e2e:a11y` : Axe WCAG 2.2 AA only (`tests/e2e/a11y.spec.ts`)
- `npm run test:e2e:interactions` : keyboard flows only (`tests/e2e/interactions.spec.ts`)

### Playwright setup

One-time browser install:

```bash
npx playwright install chromium
```

Then build frontend assets and run the suite. Playwright starts `php artisan serve` on `http://127.0.0.1:8000` unless `PLAYWRIGHT_BASE_URL` points at an already running app:

```bash
npm run build
npm run test:e2e
```

## Architecture rules (summary)

Full rules live in `AGENTS.md`. Critical points:

1. Blade + Alpine: use long-form directives only (`x-on:click`, `x-bind:class`). Never `:class` or `@click` in snippets or components.
2. Never build Tailwind class names by concatenating dynamic segments. Map variants to full static class strings.
3. Form controls must forward attributes to the native control, not only the wrapper.
4. Overlay components must teleport to `body` by default.
5. Do not invent logos, metrics, testimonials, or contact details. Use `TODO:` and log placeholders in `TODO.md`.
6. Accessibility copy must stay honest: say architected with WCAG 2.2 AA patterns in mind, never claim full compliance.
7. No Livewire, jQuery, or external icon packages. Inline SVG icons under `resources/views/components/icons/`.
8. Do not use em dashes or en dashes in copy, comments, or docs.

## Component contribution checklist

For each new `ui` component:

1. `resources/views/components/ui/{slug}.blade.php`
2. `resources/docs/components/{slug}.php` metadata
3. Paired examples under `resources/snippets/{slug}/` (`.html` and `.blade.php`)
4. Kitchen sink entry on `/ui`
5. Feature tests covering registry metadata and snippet parity

## Commit style

Use conventional commits scoped by area:

- `feat(theme): ...`
- `feat(registry): ...`
- `feat(button): ...`
- `test(docs): ...`
- `chore(ci): ...`

Keep commits small and green: run `composer lint` and `composer test` before committing.

## Pull requests

1. Describe the why, not only the what.
2. Link related issues when applicable.
3. Include screenshots for visual changes.
4. Confirm `composer check`, `npm run build`, and `npm run test:e2e` pass.
