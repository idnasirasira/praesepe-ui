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

## UI/UX craft and design engineering (mandatory)

Every component and documentation page must meet a flagship design-engineering
standard (inspired by Linear, Raycast, and Flux UI): clean, high-density,
tactile, and business-ready. Never output generic, flat Tailwind boilerplate.

### Typography and optical precision

- Headings: Always pair `font-semibold` with tight tracking (`tracking-tight`)
  and `text-balance`.
- Body and descriptions: Use `text-fg-muted leading-relaxed text-pretty`.
- Data and business numbers: Any component displaying prices, IDs, dates,
  counters, or table cells (`table`, `badge`, `pagination`, `input[type=number]`,
  `textarea` counter) MUST include `tabular-nums` so digits align vertically in
  SME dashboards.
- Optical icon sizing: Inside `sm` controls use `size-3.5` icons; inside `md`
  controls use `size-4`; inside `lg` controls use `size-4` or `size-5`. Always
  add `shrink-0` to icons inside flex containers.

### Tactile surfaces, borders, and elevation

- Controls (`button`, `input`, `select`, `switch`, `card`): Avoid flat fills.
  Combine crisp 1px borders (`border-border`) with subtle elevation
  (`shadow-2xs` or `shadow-xs`).
- Primary and solid buttons: Add a subtle top inner highlight
  (`shadow-[inset_0_1px_0_0_rgba(255,255,255,0.16),0_1px_2px_0_rgba(0,0,0,0.06)]`)
  and micro-press feedback (`active:translate-y-px` or `active:scale-[0.99]`),
  disabled under `prefers-reduced-motion`.
- Dark mode depth: Never rely on heavy black drop shadows in `.dark` mode.
  Create elevation in dark mode by stepping up surface lightness
  (`bg-surface-sunken` -> `bg-surface` -> `bg-surface-raised`) paired with
  crisp `border-border` hairlines.
- Focus rings: Use a clean two-layer optical focus ring on `:focus-visible`:
  `focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring
  focus-visible:ring-offset-2 focus-visible:ring-offset-surface`.

### Form ergonomics and states

- Consistent heights: `sm` controls (`button`, `input`, `select`) MUST share an
  exact height of `h-8` (32px, `text-xs` or `text-sm`), `md` MUST be `h-9`
  (36px, `text-sm`), and `lg` MUST be `h-10` (40px, `text-sm` or `text-base`)
  so inline form rows align to the pixel.
- Hover and focus transitions: Inputs and selects should transition border color
  smoothly (`hover:border-border-strong focus:border-brand transition-colors
  duration-150`).
- Error states: Never just turn a border red. Combine
  `border-danger focus-visible:ring-danger` on the input with an inline warning
  icon plus crisp `text-xs text-danger` helper message below.

### Motion and choreography (Alpine transitions)

- Never pop overlays (`modal`, `dropdown`, `tooltip`, `toast`, mobile drawer) in
  or out abruptly.
- Dropdowns and tooltips:
  `x-transition:enter="transition ease-out duration-150"`
  `x-transition:enter-start="opacity-0 scale-95 translate-y-0.5"`
  `x-transition:enter-end="opacity-100 scale-100 translate-y-0"`
  and a faster exit (`duration-100`).
- Modals: Backdrop fades (`opacity-0` to `opacity-100 duration-200`) while the
  panel scales or slides subtly (`opacity-0 scale-95 translate-y-2` to
  `opacity-100 scale-100 translate-y-0 duration-200 ease-out`).
