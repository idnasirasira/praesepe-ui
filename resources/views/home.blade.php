@extends('layouts.app')

@section('title', config('ui-docs.name').' · Blade components for Laravel')
@section('meta_description', 'Copy-paste Blade + Tailwind 4 + Alpine 3 components for Laravel teams. Dogfooded at ui.praesepe.id.')

@section('body')
<div class="min-h-dvh bg-surface text-fg">
    <x-ui.navbar :brand-href="route('home')" :brand-name="config('ui-docs.name')" class="z-20">
        <x-slot:links>
            <x-ui.navbar.link :href="route('docs.index')">Docs</x-ui.navbar.link>
            <x-ui.navbar.link :href="route('ui.index')">Kitchen sink</x-ui.navbar.link>
        </x-slot:links>

        <x-slot:actions>
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-2">
                <div class="flex items-center gap-2">
                    <x-docs.theme-switcher />
                    <x-docs.dark-mode-toggle />
                </div>
                @if (config('ui-docs.github_url'))
                    <a
                        href="{{ config('ui-docs.github_url') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-9 items-center justify-center rounded-control border border-border bg-surface-raised px-3 text-sm font-medium text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken md:h-8 md:px-2.5 md:text-xs"
                    >
                        GitHub
                    </a>
                @endif
                <x-ui.button variant="outline" size="sm" class="w-full justify-center md:w-auto" :href="route('docs.index')">Get started</x-ui.button>
            </div>
        </x-slot:actions>
    </x-ui.navbar>

    <main id="main-content">
        <section class="relative overflow-hidden border-b border-border">
            <div
                class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,_color-mix(in_oklch,var(--ui-brand)_16%,transparent),_transparent_55%),linear-gradient(180deg,var(--ui-surface-sunken),var(--ui-surface))]"
                aria-hidden="true"
            ></div>

            <div class="relative mx-auto max-w-6xl px-4 pb-16 pt-12 sm:px-6 sm:pb-20 sm:pt-16">
                <p class="text-sm font-semibold tracking-[0.18em] text-brand uppercase">
                    {{ config('ui-docs.name') }}
                </p>
                <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-balance text-fg sm:text-5xl lg:text-[3.25rem] lg:leading-[1.1]">
                    Blade components you can paste into Laravel and ship.
                </h1>
                <p class="mt-4 max-w-2xl text-lg text-fg-muted leading-relaxed text-pretty">
                    Tailwind CSS 4 tokens and Alpine.js 3 behavior, dogfooded for Indonesian SME software. Architected with WCAG 2.2 AA patterns in mind.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button size="lg" :href="route('docs.index')">Read the docs</x-ui.button>
                    <x-ui.button size="lg" variant="outline" :href="route('docs.components.index')">Browse components</x-ui.button>
                </div>

                {{-- Interactive SME Workspace Showcase --}}
                <div
                    class="mt-12"
                    x-data="{
                        workspace: 'orders',
                        theme: window.PraesepeTheme?.getStoredTheme() || 'praesepe',
                        scheme: window.PraesepeTheme?.getStoredColorScheme() || 'system',
                        tokens: {},
                        readTokens() {
                            const styles = getComputedStyle(document.documentElement);
                            this.tokens = {
                                brand: styles.getPropertyValue('--ui-brand').trim(),
                                surface: styles.getPropertyValue('--ui-surface').trim(),
                                raised: styles.getPropertyValue('--ui-surface-raised').trim(),
                                sunken: styles.getPropertyValue('--ui-surface-sunken').trim(),
                                border: styles.getPropertyValue('--ui-border').trim(),
                                fg: styles.getPropertyValue('--ui-fg').trim(),
                            };
                        },
                        setTheme(id) {
                            this.theme = id;
                            window.PraesepeTheme?.setTheme(id);
                            this.$nextTick(() => this.readTokens());
                        },
                        setScheme(id) {
                            this.scheme = id;
                            window.PraesepeTheme?.setColorScheme(id);
                            this.$nextTick(() => this.readTokens());
                        },
                        init() {
                            this.readTokens();
                            window.addEventListener('ui-theme-change', () => {
                                this.theme = window.PraesepeTheme?.getStoredTheme() || this.theme;
                                this.readTokens();
                            });
                            window.addEventListener('ui-color-scheme-change', () => {
                                this.scheme = window.PraesepeTheme?.getStoredColorScheme() || this.scheme;
                                this.readTokens();
                            });
                        }
                    }"
                >
                    <div class="mb-3 flex flex-wrap items-end justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold tracking-tight text-fg">Interactive SME workspace</p>
                            <p class="mt-1 text-sm text-fg-muted">Live components above the fold. No screenshots.</p>
                        </div>
                        <div class="inline-flex rounded-control border border-border bg-surface-raised p-0.5 shadow-2xs" role="tablist" aria-label="Workspace views">
                            <button type="button" role="tab" class="rounded-[calc(var(--ui-radius-control)-2px)] px-3 py-1.5 text-xs font-medium transition-colors duration-150" x-bind:class="workspace === 'orders' ? 'bg-surface-sunken text-fg' : 'text-fg-muted hover:text-fg'" x-bind:aria-selected="(workspace === 'orders').toString()" x-on:click="workspace = 'orders'">Orders &amp; invoices</button>
                            <button type="button" role="tab" class="rounded-[calc(var(--ui-radius-control)-2px)] px-3 py-1.5 text-xs font-medium transition-colors duration-150" x-bind:class="workspace === 'customers' ? 'bg-surface-sunken text-fg' : 'text-fg-muted hover:text-fg'" x-bind:aria-selected="(workspace === 'customers').toString()" x-on:click="workspace = 'customers'">Customers &amp; roles</button>
                            <button type="button" role="tab" class="rounded-[calc(var(--ui-radius-control)-2px)] px-3 py-1.5 text-xs font-medium transition-colors duration-150" x-bind:class="workspace === 'theme' ? 'bg-surface-sunken text-fg' : 'text-fg-muted hover:text-fg'" x-bind:aria-selected="(workspace === 'theme').toString()" x-on:click="workspace = 'theme'">Theme tuner</button>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-card border border-border bg-surface-raised shadow-md ring-1 ring-black/5">
                        {{-- Tab 1: Orders & Invoice Dashboard --}}
                        <div x-show="workspace === 'orders'" role="tabpanel">
                            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-border px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold tracking-tight text-fg">Toko Kita Ops</p>
                                    <p class="text-xs text-fg-muted">Invoice and order desk · INV-2026-089</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <x-ui.dropdown label="Bulk actions" align="right">
                                        <x-ui.dropdown.item>Mark as paid</x-ui.dropdown.item>
                                        <x-ui.dropdown.item>Export CSV</x-ui.dropdown.item>
                                        <x-ui.dropdown.separator />
                                        <x-ui.dropdown.item variant="danger">Void selected</x-ui.dropdown.item>
                                    </x-ui.dropdown>
                                    <x-ui.modal
                                        id="home-new-invoice"
                                        title="Create invoice"
                                        description="Draft INV-2026-092 for Toko Maju Jaya."
                                    >
                                        <x-slot:trigger>
                                            <x-ui.button size="sm">New invoice</x-ui.button>
                                        </x-slot:trigger>
                                        <div class="space-y-3">
                                            <x-ui.input label="Customer" name="customer" value="Toko Maju Jaya" />
                                            <x-ui.input label="Amount (IDR)" name="amount" value="2450000" trailing-addon="IDR" />
                                        </div>
                                        <x-slot:action>
                                            <x-ui.button x-on:click="hide(); window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'success', title: 'Draft saved', message: 'INV-2026-092 ready for review.' } }))">Save draft</x-ui.button>
                                        </x-slot:action>
                                    </x-ui.modal>
                                </div>
                            </div>

                            <div class="space-y-4 px-4 py-4">
                                <div class="flex flex-wrap items-end gap-3">
                                    <div class="min-w-[12rem] flex-1">
                                        <x-ui.input size="sm" name="filter" placeholder="Filter by customer or INV-" aria-label="Filter invoices" />
                                    </div>
                                    <x-ui.select size="sm" name="status" aria-label="Status filter" class="w-40">
                                        <option value="">All statuses</option>
                                        <option value="paid">Paid</option>
                                        <option value="pending">Pending</option>
                                        <option value="overdue">Overdue</option>
                                    </x-ui.select>
                                    <div class="flex flex-wrap gap-2">
                                        <x-ui.badge color="success" size="sm" dot>Paid today: 3</x-ui.badge>
                                        <x-ui.badge color="warning" size="sm" dot>Due soon: 2</x-ui.badge>
                                    </div>
                                </div>

                                <x-ui.table striped hoverable label="Recent invoices">
                                    <x-ui.table.head>
                                        <x-ui.table.cell header>Invoice</x-ui.table.cell>
                                        <x-ui.table.cell header>Customer</x-ui.table.cell>
                                        <x-ui.table.cell header>Status</x-ui.table.cell>
                                        <x-ui.table.cell header sortable sort="descending" numeric>Total</x-ui.table.cell>
                                    </x-ui.table.head>
                                    <x-ui.table.body>
                                        <x-ui.table.row>
                                            <x-ui.table.cell numeric>INV-2026-089</x-ui.table.cell>
                                            <x-ui.table.cell>CV Nusantara</x-ui.table.cell>
                                            <x-ui.table.cell><x-ui.badge color="success" size="sm">Paid</x-ui.badge></x-ui.table.cell>
                                            <x-ui.table.cell numeric>Rp 2.450.000</x-ui.table.cell>
                                        </x-ui.table.row>
                                        <x-ui.table.row>
                                            <x-ui.table.cell numeric>INV-2026-090</x-ui.table.cell>
                                            <x-ui.table.cell>Warung Sederhana</x-ui.table.cell>
                                            <x-ui.table.cell><x-ui.badge color="warning" size="sm">Pending</x-ui.badge></x-ui.table.cell>
                                            <x-ui.table.cell numeric>USD 480.00</x-ui.table.cell>
                                        </x-ui.table.row>
                                        <x-ui.table.row>
                                            <x-ui.table.cell numeric>ORD-2201</x-ui.table.cell>
                                            <x-ui.table.cell>Toko Maju Jaya</x-ui.table.cell>
                                            <x-ui.table.cell><x-ui.badge color="info" size="sm">Shipped</x-ui.badge></x-ui.table.cell>
                                            <x-ui.table.cell numeric>Rp 1.125.000</x-ui.table.cell>
                                        </x-ui.table.row>
                                    </x-ui.table.body>
                                </x-ui.table>
                            </div>
                        </div>

                        {{-- Tab 2: Customer & Role Settings --}}
                        <div x-show="workspace === 'customers'" x-cloak role="tabpanel" class="space-y-6 px-4 py-4">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold tracking-tight text-fg">Team access</p>
                                    <p class="mt-1 text-sm text-fg-muted leading-relaxed">Roles for finance, ops, and warehouse owners.</p>
                                </div>
                                <x-ui.avatar.group>
                                    <x-ui.avatar name="Siti Rahma" status="online" />
                                    <x-ui.avatar name="Budi Santoso" status="busy" />
                                    <x-ui.avatar name="Ayu Lestari" />
                                </x-ui.avatar.group>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <x-ui.card variant="sunken">
                                    <p class="text-sm font-semibold tracking-tight text-fg">Notifications</p>
                                    <div class="mt-3 space-y-3">
                                        <x-ui.switch size="sm" name="remind" label="Auto-remind unpaid invoices" checked />
                                        <x-ui.switch size="sm" name="stock" label="Low stock alerts (Gudang A)" checked />
                                        <x-ui.switch size="sm" name="digest" label="Weekly finance digest" />
                                    </div>
                                    <div class="mt-4">
                                        <x-ui.button
                                            size="sm"
                                            variant="outline"
                                            x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'info', title: 'Preferences saved', message: 'Team notification rules updated.' } }))"
                                        >
                                            Save &amp; toast
                                        </x-ui.button>
                                    </div>
                                </x-ui.card>

                                <div class="space-y-2">
                                    <p class="text-sm font-semibold tracking-tight text-fg">Default role</p>
                                    <x-ui.radio name="home_role" value="owner" label="Owner" description="Full billing and void rights" checked variant="card" />
                                    <x-ui.radio name="home_role" value="finance" label="Finance" description="Invoices and payouts" variant="card" />
                                    <x-ui.radio name="home_role" value="ops" label="Operations" description="Stock and fulfillment" variant="card" />
                                </div>
                            </div>
                        </div>

                        {{-- Tab 3: Theme Token Live Tuner --}}
                        <div x-show="workspace === 'theme'" x-cloak role="tabpanel" class="space-y-6 px-4 py-4">
                            <div>
                                <p class="text-sm font-semibold tracking-tight text-fg">Theme token live tuner</p>
                                <p class="mt-1 text-sm text-fg-muted leading-relaxed">Click a theme or scheme. CSS variables update instantly across this workspace.</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <template x-for="item in [
                                    { id: 'praesepe', label: 'Praesepe' },
                                    { id: 'minimal', label: 'Minimal' },
                                    { id: 'warm', label: 'Warm' },
                                ]" x-bind:key="item.id">
                                    <button
                                        type="button"
                                        class="inline-flex h-9 items-center rounded-control border px-3.5 text-sm font-medium transition-colors duration-150"
                                        x-bind:class="theme === item.id ? 'border-brand bg-brand/10 text-brand' : 'border-border bg-surface-raised text-fg hover:bg-surface-sunken'"
                                        x-on:click="setTheme(item.id)"
                                        x-text="item.label"
                                    ></button>
                                </template>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <template x-for="item in [
                                    { id: 'light', label: 'Light' },
                                    { id: 'dark', label: 'Dark' },
                                    { id: 'system', label: 'System' },
                                ]" x-bind:key="item.id">
                                    <button
                                        type="button"
                                        class="inline-flex h-9 items-center rounded-control border px-3.5 text-sm font-medium transition-colors duration-150"
                                        x-bind:class="scheme === item.id ? 'border-brand bg-brand/10 text-brand' : 'border-border bg-surface-raised text-fg hover:bg-surface-sunken'"
                                        x-on:click="setScheme(item.id)"
                                        x-text="item.label"
                                    ></button>
                                </template>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                <template x-for="entry in Object.entries(tokens)" x-bind:key="entry[0]">
                                    <div class="rounded-control border border-border bg-surface-sunken/60 p-3">
                                        <p class="text-[10px] font-semibold uppercase tracking-wider text-fg-subtle" x-text="'--ui-' + entry[0]"></p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="size-6 shrink-0 rounded-control border border-border" x-bind:style="'background:' + entry[1]"></span>
                                            <code class="truncate text-xs tabular-nums text-fg" x-text="entry[1]"></code>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 rounded-control border border-border bg-surface p-3">
                                <x-ui.button size="sm">Primary</x-ui.button>
                                <x-ui.button size="sm" variant="secondary">Secondary</x-ui.button>
                                <x-ui.badge color="brand" size="sm">Brand soft</x-ui.badge>
                                <x-ui.badge color="success" size="sm" dot>In stock</x-ui.badge>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-border bg-surface-raised">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
                <h2 class="text-2xl font-semibold tracking-tight text-fg">Three steps to ship</h2>
                <p class="mt-2 max-w-2xl text-fg-muted leading-relaxed">No runtime package tax. Copy the snippet, wire tokens, deploy.</p>

                <ol class="mt-10 grid gap-8 sm:grid-cols-3">
                    <li>
                        <p class="text-xs font-semibold tracking-[0.16em] text-brand uppercase">Step 01</p>
                        <h3 class="mt-2 text-lg font-semibold tracking-tight text-fg">Copy snippet or Blade</h3>
                        <p class="mt-2 text-sm text-fg-muted leading-relaxed">Grab HTML + Alpine or an <code class="rounded bg-surface-sunken px-1">&lt;x-ui.*&gt;</code> component from the docs.</p>
                    </li>
                    <li>
                        <p class="text-xs font-semibold tracking-[0.16em] text-brand uppercase">Step 02</p>
                        <h3 class="mt-2 text-lg font-semibold tracking-tight text-fg">Drop theme.css</h3>
                        <p class="mt-2 text-sm text-fg-muted leading-relaxed">Import semantic <code class="rounded bg-surface-sunken px-1">--ui-*</code> tokens once. Themes and dark mode swap at runtime.</p>
                    </li>
                    <li>
                        <p class="text-xs font-semibold tracking-[0.16em] text-brand uppercase">Step 03</p>
                        <h3 class="mt-2 text-lg font-semibold tracking-tight text-fg">Ship</h3>
                        <p class="mt-2 text-sm text-fg-muted leading-relaxed">Keep ownership of the markup. Customize freely inside your Laravel app.</p>
                    </li>
                </ol>
            </div>
        </section>

        <section class="border-b border-border">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
                <h2 class="text-2xl font-semibold tracking-tight text-fg">When to choose what</h2>
                <p class="mt-2 max-w-2xl text-fg-muted leading-relaxed">
                    Honest positioning. Pick the stack that matches your rendering model, not a trend.
                </p>

                <div class="mt-8">
                    <x-ui.table hoverable label="UI library comparison">
                        <x-ui.table.head>
                            <x-ui.table.cell header>Library</x-ui.table.cell>
                            <x-ui.table.cell header>Choose it when</x-ui.table.cell>
                            <x-ui.table.cell header>Trade-off</x-ui.table.cell>
                        </x-ui.table.head>
                        <x-ui.table.body>
                            <x-ui.table.row>
                                <x-ui.table.cell><span class="font-medium text-fg">Praesepe UI</span></x-ui.table.cell>
                                <x-ui.table.cell>You want copy-paste Blade + Tailwind 4 + Alpine 3 with semantic themes and docs that dogfood the same components.</x-ui.table.cell>
                                <x-ui.table.cell>You own the markup. There is no paid component marketplace or Livewire runtime.</x-ui.table.cell>
                            </x-ui.table.row>
                            <x-ui.table.row>
                                <x-ui.table.cell><span class="font-medium text-fg">Flux UI</span></x-ui.table.cell>
                                <x-ui.table.cell>Your app is Livewire-first and you want an official, integrated component layer for that stack.</x-ui.table.cell>
                                <x-ui.table.cell>Couples UI to Livewire and a commercial product surface.</x-ui.table.cell>
                            </x-ui.table.row>
                            <x-ui.table.row>
                                <x-ui.table.cell><span class="font-medium text-fg">shadcn/ui</span></x-ui.table.cell>
                                <x-ui.table.cell>You build in React (or a React-adjacent toolchain) and want copy-paste primitives in that ecosystem.</x-ui.table.cell>
                                <x-ui.table.cell>Not a Blade workflow. Requires a JS component tree.</x-ui.table.cell>
                            </x-ui.table.row>
                            <x-ui.table.row>
                                <x-ui.table.cell><span class="font-medium text-fg">Penguin UI</span></x-ui.table.cell>
                                <x-ui.table.cell>You want Alpine + Tailwind HTML snippets with a broad marketing-site catalog.</x-ui.table.cell>
                                <x-ui.table.cell>Less opinionated around Laravel Blade registries, semantic OKLCH themes, and SME ops examples.</x-ui.table.cell>
                            </x-ui.table.row>
                        </x-ui.table.body>
                    </x-ui.table>
                </div>
            </div>
        </section>

        <section class="bg-surface-sunken">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
                <x-docs.cta />
                <p class="mt-6 text-xs text-fg-subtle">
                    Marketing metrics, logos, and client testimonials stay as TODO until real data is approved. See TODO.md.
                </p>
            </div>
        </section>
    </main>

    <x-docs.footer />
</div>
@endsection
