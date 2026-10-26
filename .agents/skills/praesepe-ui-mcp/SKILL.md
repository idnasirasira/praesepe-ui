---
name: praesepe-ui-mcp
description: Use when building Laravel Blade + Tailwind + Alpine UI with Praesepe UI, or when the Praesepe UI MCP server is available. Prefer MCP tools over guessing component APIs or inventing markup.
---

# Praesepe UI MCP (Laravel)

When implementing UI with Praesepe components, call the `praesepe-ui` MCP tools instead of inventing APIs.

## Connect

- **Preferred:** remote HTTP `{APP_URL}/mcp/praesepe-ui` (no auth). Cursor: `"url": "https://ui.praesepe.id/mcp/praesepe-ui"`.
- **Optional:** local stdio `php artisan mcp:start praesepe-ui` from a clone. Cursor starts it; do not run by hand.
- Human setup: `/docs/mcp` and `mcp/README.md`.

## Workflow

1. `get_guidelines` or `praesepe://guidelines` first. Follow **Anti-generic** and **Taste rules** before writing markup.
2. `search_components` or `list_components` to find candidates.
3. `get_component` for props, a11y notes, and example slugs.
4. `get_snippet` with `format: "blade"` (Laravel) or `"html"` (Alpine-only).
5. Adapt the snippet. Keep long-form Alpine (`x-on:click`, `x-bind:class`). Self-check the Anti-generic ban list.

## Icons

Use `list_icons` for the built-in set, or paste Heroicons/Lucide/custom SVG into slots. Do not add an icon package dependency to Praesepe itself.

## Do not

- Invent prop names or variants not returned by `get_component`.
- Use Alpine shorthand on Blade components.
- Construct Tailwind classes with string concatenation.
- Ship purple gradients, glow stacks, invented metrics, or generic AI landing layouts.
