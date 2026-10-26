# Praesepe UI Agent Rules

These rules govern every AI or human contribution to this repository. Prefer them
over improvisation. Laravel Boost foundation guidance still applies for framework
API accuracy; when rules conflict, this file wins for Praesepe UI architecture.

## Stack

- Laravel 12.x / 13.x (exact version logged in `TODO.md`)
- PHP 8.3+
- Tailwind CSS v4 via `@tailwindcss/vite`
- Alpine.js v3 + `@alpinejs/focus` via npm
- No Livewire, no jQuery, no external icon packages

## Quality gates

- Atomic conventional commits (`feat(theme):`, `feat(registry):`, `feat(button):`)
- Run `composer lint` and `composer test` before every commit
- Never commit broken code or failing tests
- After PHP edits, run `vendor/bin/pint --dirty` (or `composer format`) before lint
- Zero hallucination: never invent logos, clients, testimonials, metrics, star
  counts, or contact numbers. Use `TODO:` and log placeholders in `TODO.md`
- Originality: write markup, Alpine, CSS tokens, and copy from scratch
- Honest a11y copy: never claim 100% WCAG compliant or fully accessible. Use
  "architected with WCAG 2.2 AA patterns in mind" and document exact keyboard/ARIA
- Typography: clear technical English. Never use em dashes or en dashes. Use
  commas, colons, or periods

## Strict typing

Add `declare(strict_types=1);` at the top of every PHP file in `app/`, `config/`,
and `tests/`.

## Tailwind v4 source scanning

In `resources/css/app.css` always declare:

```css
@source "../views/**/*.blade.php";
@source "../snippets/**/*.html";
@source "../docs/**/*.php";
```

Import `theme.css` beside `@import "tailwindcss";`.

## Blade + Alpine syntax safety

1. Always use long-form Alpine directives (`x-on:click`, `x-bind:class`,
   `x-bind:aria-expanded`) in both `.blade.php` and `.html` files. Never use
   `:class` or `@click` shorthand (a leading colon on `<x-ui.*>` is evaluated as
   a PHP expression by Blade).
2. Never construct Tailwind classes via string concatenation (for example
   `"bg-{$color}"`). Map variants with complete static class strings in PHP arrays.
3. Form wrappers (`input`, `select`, `textarea`, `checkbox`, `radio`, `switch`)
   must separate wrapper attributes from control attributes. Pass
   `$attributes->except(['class'])` to the underlying control so `name`, `value`,
   `required`, `placeholder`, `x-model`, and `wire:model` work in production.

## Portal and stacking

Interactive overlays (`modal`, `toast`) must support or default to
`x-teleport="body"` so they never clip inside `overflow-hidden` preview canvases.

## Registry security and caching

1. Route `{slug}` parameters must use `->where('slug', '[a-z0-9-]+')`.
2. `SnippetRepository` must validate resolved paths with `realpath()` so they stay
   inside `resource_path('snippets')`.
3. `ComponentRegistry` must render live previews by evaluating the `.blade.php`
   snippet with `Blade::render()`.
4. Cache the assembled registry and search index in production with
   `Cache::rememberForever('ui.registry', ...)` when `! app()->isLocal()`.

## Icons

Build reusable inline SVG Blade components under
`resources/views/components/icons/` with default `size-4` or `size-5` classes and
`aria-hidden="true"`.

## Stateless docs

No database queries for docs routes. Keep session and cache drivers as `file` or
`array` in `.env.example`.

## Skills

Activate project skills under `.cursor/skills/` when working in matching domains
(Laravel best practices, Tailwind, testing, deploying to Cloud).
