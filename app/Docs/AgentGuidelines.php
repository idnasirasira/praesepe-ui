<?php

declare(strict_types=1);

namespace App\Docs;

final class AgentGuidelines
{
    public static function text(): string
    {
        return <<<'MD'
# Praesepe UI authoring guidelines for agents

Consumer-facing rules for implementing UI with Praesepe. Maintainer-only Cursor rules stay private; this document is the source of truth over MCP (`get_guidelines` and the `praesepe://guidelines` resource).

Read **Anti-generic** and **Taste rules** on every UI task before writing markup. Prefer `get_snippet` over inventing layout.

## Anti-generic (never ship AI-default UI)

Refuse the default LLM look. If the screen could belong to any SaaS after swapping the logo, rewrite it.

### Ban list
- Purple-on-white or purple-to-indigo gradient themes; neon glow; multi-layer soft shadows; emoji as decoration
- Warm cream `#F4F1Ea`-ish canvases with terracotta accents and default serif display as a stock "premium" combo
- Broadsheet / newspaper pastiche: hairline rules, zero radius, dense multi-column filler
- Flat Tailwind boilerplate cards everywhere; pill clusters; stat strips; icon-row feature grids with no real content
- Invented logos, clients, testimonials, metrics, star counts, or phone numbers (use `TODO:`)
- Em dashes or en dashes in copy; hype marketing filler ("revolutionize", "seamless", "delightful")
- Claiming "100% WCAG compliant" or "fully accessible". Say "architected with WCAG 2.2 AA patterns in mind" only
- Alpine shorthand on Blade (`:class`, `@click` on `<x-ui.*>`); dynamic Tailwind class strings (`bg-${color}`)

### Composition (marketing / landing)
- One composition in the first viewport, not a dashboard collage
- Brand first: product name is a hero-level signal, not a tiny nav label
- Hero budget: brand, one headline, one short supporting sentence, one CTA group, one dominant visual. No stats, schedules, address blocks, or promo chips in the first viewport
- Full-bleed hero when the page is promotional. No inset hero cards, floating stickers, or overlays on media
- Cards only when they contain a real interaction. If removing border/shadow/radius does not hurt understanding, do not use a card
- One job per section: one purpose, one headline, usually one short supporting sentence
- Real visual anchor (product, place, context). Decorative gradients alone are not the idea

### Density and craft defaults
- Prefer high-density, tactile, business-ready UI (Linear / Raycast / Flux caliber), not airy marketing fluff in product surfaces
- Clear visual direction with CSS variables / Praesepe semantic tokens. Commit to a look; do not mix three aesthetics

## Taste rules (Praesepe craft bar)

### Typography and optical precision
- Headings: `font-semibold tracking-tight text-balance`
- Body: `text-fg-muted leading-relaxed text-pretty`
- Prices, IDs, dates, counters, table cells, badges, pagination: `tabular-nums`
- Icons in flex: always `shrink-0`. Optical sizes: `sm` controls → `size-3.5`, `md` → `size-4`, `lg` → `size-4` or `size-5`

### Surfaces, borders, elevation
- Controls: crisp `border-border` + `shadow-2xs` / `shadow-xs`. Avoid flat fills
- Primary / solid buttons: subtle top inset highlight + `active:translate-y-px` or `active:scale-[0.99]` (disable under `prefers-reduced-motion`)
- Dark mode: elevate by stepping `bg-surface-sunken` → `bg-surface` → `bg-surface-raised` with hairline borders. No heavy black drop shadows
- Focus: `focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface`

### Forms
- Shared heights: `sm` = `h-8`, `md` = `h-9`, `lg` = `h-10` so inline rows align
- Inputs: `hover:border-border-strong focus:border-brand transition-colors duration-150`
- Errors: `border-danger` + `focus-visible:ring-danger` + inline warning icon + `text-xs text-danger` helper. Never red border alone
- Form wrappers forward control attrs with `$attributes->except(['class'])`

### Motion
- Never hard-pop overlays. Dropdown/tooltip: enter ~150ms ease-out (`opacity-0 scale-95 translate-y-0.5` → settled), exit faster (~100ms)
- Modal: backdrop fade 200ms; panel `opacity-0 scale-95 translate-y-2` → settled
- Use motion for hierarchy, not noise. Respect `prefers-reduced-motion`

### Product vs marketing
- Product / docs / SME dashboards: dense, tokenized Praesepe components, tabular data, quiet chrome
- Marketing pages: brand-led composition rules above; still use Praesepe controls for CTAs and forms

## Stack
- Blade + Tailwind CSS v4 + Alpine.js 3 (+ `@alpinejs/focus`)
- No Livewire, jQuery, or required icon packages in Praesepe itself
- Prefer Laravel 12/13 in consuming apps

## Blade and Alpine
1. Prefer Blade components under `resources/views/components/ui/`.
2. Alpine: long-form only (`x-on:click`, `x-bind:class`, `x-bind:aria-expanded`). Never `:class` or `@click` on `<x-ui.*>`.
3. Never build Tailwind classes via string concat. Map variants with full static class strings in PHP arrays.
4. Overlays (`modal`, `toast`, drawers): `x-teleport="body"`.
5. Icons: `x-icons.*` or paste Heroicons / Lucide / custom SVG into slots. Icon-only controls need `aria-label`.

## Theme tokens
- Semantic utilities only (`bg-brand`, `text-fg`, `border-border`, `bg-surface`, `text-danger`)
- Tokens as `--ui-*` in `theme.css`, mapped with `@theme inline`
- Themes: `praesepe`, `minimal`, `warm` (light + dark each)
- Warning: clean amber-orange with readable `on-*` contrast

## Connect
- Prefer remote HTTP: `https://ui.praesepe.id/mcp/praesepe-ui` (no auth)
- Optional local stdio: Cursor runs `php artisan mcp:start praesepe-ui` (do not start manually)
- Human setup: `/docs/mcp`

## Workflow
1. Read these guidelines (`get_guidelines` or `praesepe://guidelines`), especially Anti-generic + Taste rules
2. `search_components` or `list_components`
3. `get_component` for props + a11y + example slugs
4. `get_snippet` (`blade` or `html`)
5. Adapt into the app. Keep Alpine long-form. Self-check against the Anti-generic ban list before finishing
MD;
    }

    /**
     * Short Cursor User Rules / agent prompt for consumers. Paste into client rules after enabling the MCP server.
     */
    public static function userPrompt(): string
    {
        $mcpUrl = (string) config('ui-docs.mcp_url');
        $docsUrl = rtrim((string) config('ui-docs.url'), '/').'/docs/mcp';

        return <<<MD
# Praesepe UI MCP

When building Laravel Blade + Tailwind + Alpine UI with Praesepe UI, use the `praesepe-ui` MCP tools. Do not invent component APIs, props, variants, or markup.

MCP: {$mcpUrl}
Setup: {$docsUrl}

## Workflow
1. `get_guidelines` or resource `praesepe://guidelines` first. Follow Anti-generic and Taste rules before writing markup.
2. `search_components` or `list_components` to find candidates.
3. `get_component` for props, a11y notes, and example slugs.
4. `get_snippet` with format `blade` (Laravel) or `html` (Alpine-only).
5. Adapt the snippet. Keep long-form Alpine (`x-on:click`, `x-bind:class`). Self-check the Anti-generic ban list.

## Do not
- Invent prop names or variants not returned by `get_component`.
- Use Alpine shorthand on Blade components (`:class`, `@click` on `<x-ui.*>`).
- Construct Tailwind classes with string concatenation.
- Ship purple gradients, glow stacks, invented metrics, or generic AI landing layouts.
MD;
    }
}
