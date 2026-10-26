# Praesepe UI Agent Rules

These rules govern every AI or human contribution to this repository. Prefer them
over improvisation. Laravel Boost foundation guidance still applies for framework
API accuracy; when rules conflict, this file wins for Praesepe UI architecture.

## Stack

- Laravel 12.x / 13.x (exact version logged in `TODO.md`)
- PHP 8.4+
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

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.4. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== tests rules ===

# Test Enforcement

- Add or update tests for behavior and logic changes when a test provides meaningful regression coverage.
- Pure copy, styling, and layout-only changes do not require new or updated tests.
- When test coverage applies, run the affected tests and ensure they pass.
- Test the changed behavior and its important failure modes, but do not add tests beyond them.
- Read the `testing-best-practices` skill before writing tests.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.
- After the feature tests pass, ask the user to run the complete suite with `php artisan test --compact`.

</laravel-boost-guidelines>
