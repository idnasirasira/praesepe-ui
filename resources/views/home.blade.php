@extends('layouts.app')

@section('title', config('ui-docs.name').' · Blade components for Laravel')
@section('meta_description', 'Copy-paste Blade + Tailwind 4 + Alpine 3 components for Laravel teams. Dogfooded at ui.praesepe.id.')

@section('body')
<div class="min-h-dvh bg-surface text-fg">
    <header class="relative z-20 border-b border-border/80 bg-surface/80 backdrop-blur">
        <div class="mx-auto flex h-14 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6">
            <a href="{{ route('home') }}" class="text-base font-semibold tracking-tight text-fg">
                {{ config('ui-docs.name') }}
            </a>
            <nav class="flex items-center gap-2 text-sm sm:gap-3" aria-label="Primary">
                <a href="{{ route('docs.index') }}" class="hidden text-fg-muted hover:text-fg sm:inline">Docs</a>
                <a href="{{ route('ui.index') }}" class="hidden text-fg-muted hover:text-fg sm:inline">Kitchen sink</a>
                <x-ui.button variant="outline" size="sm" :href="route('docs.index')">Get started</x-ui.button>
            </nav>
        </div>
    </header>

    <main id="main-content">
        {{-- Hero: brand, headline, support, CTAs, then theme controls + live preview --}}
        <section class="relative overflow-hidden border-b border-border">
            <div
                class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,_color-mix(in_oklch,var(--ui-brand)_18%,transparent),_transparent_55%),linear-gradient(180deg,var(--ui-surface-sunken),var(--ui-surface))]"
                aria-hidden="true"
            ></div>

            <div class="relative mx-auto max-w-6xl px-4 pb-16 pt-14 sm:px-6 sm:pb-20 sm:pt-20">
                <p class="text-sm font-semibold tracking-[0.18em] text-brand uppercase">
                    {{ config('ui-docs.name') }}
                </p>
                <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-fg sm:text-5xl lg:text-[3.25rem] lg:leading-[1.1]">
                    Blade components you can paste into Laravel and ship.
                </h1>
                <p class="mt-4 max-w-2xl text-lg text-fg-muted">
                    Tailwind CSS 4 tokens and Alpine.js 3 behavior, dogfooded for Indonesian SME software. Architected with WCAG 2.2 AA patterns in mind.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button size="lg" :href="route('docs.index')">Read the docs</x-ui.button>
                    <x-ui.button size="lg" variant="outline" :href="route('docs.components.index')">Browse components</x-ui.button>
                </div>

                <div class="mt-12 space-y-3">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm font-medium text-fg">Live SME invoice preview</p>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-docs.theme-switcher />
                            <x-docs.dark-mode-toggle />
                        </div>
                    </div>

                    <x-ui.card class="overflow-hidden border-border/80 shadow-md">
                        <x-slot:header>
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-fg">Toko Kita Ops</p>
                                    <p class="text-xs text-fg-muted">Invoice and order desk</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <x-ui.dropdown label="Bulk actions" align="right">
                                        <x-ui.dropdown.item>Mark as paid</x-ui.dropdown.item>
                                        <x-ui.dropdown.item>Export CSV</x-ui.dropdown.item>
                                        <x-ui.dropdown.separator />
                                        <x-ui.dropdown.item variant="danger">Void selected</x-ui.dropdown.item>
                                    </x-ui.dropdown>
                                    <x-ui.button size="sm">New invoice</x-ui.button>
                                </div>
                            </div>
                        </x-slot:header>

                        <div class="space-y-4">
                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-control bg-surface-sunken px-3 py-2">
                                <x-ui.switch size="sm" label="Auto-remind unpaid invoices" checked />
                                <div class="flex flex-wrap gap-2">
                                    <x-ui.badge color="success" size="sm" dot>Paid today: 3</x-ui.badge>
                                    <x-ui.badge color="warning" size="sm" dot>Due soon: 2</x-ui.badge>
                                </div>
                            </div>

                            <x-ui.table striped hoverable label="Recent invoices">
                                <x-ui.table.head>
                                    <x-ui.table.cell header>Faktur</x-ui.table.cell>
                                    <x-ui.table.cell header>Pelanggan</x-ui.table.cell>
                                    <x-ui.table.cell header>Status</x-ui.table.cell>
                                    <x-ui.table.cell header sortable sort="descending">Total</x-ui.table.cell>
                                </x-ui.table.head>
                                <x-ui.table.body>
                                    <x-ui.table.row>
                                        <x-ui.table.cell>INV-1042</x-ui.table.cell>
                                        <x-ui.table.cell>CV Nusantara</x-ui.table.cell>
                                        <x-ui.table.cell><x-ui.badge color="success" size="sm">Lunas</x-ui.badge></x-ui.table.cell>
                                        <x-ui.table.cell>Rp 2.450.000</x-ui.table.cell>
                                    </x-ui.table.row>
                                    <x-ui.table.row>
                                        <x-ui.table.cell>INV-1043</x-ui.table.cell>
                                        <x-ui.table.cell>Warung Sederhana</x-ui.table.cell>
                                        <x-ui.table.cell><x-ui.badge color="warning" size="sm">Jatuh tempo</x-ui.badge></x-ui.table.cell>
                                        <x-ui.table.cell>Rp 780.000</x-ui.table.cell>
                                    </x-ui.table.row>
                                    <x-ui.table.row>
                                        <x-ui.table.cell>ORD-2201</x-ui.table.cell>
                                        <x-ui.table.cell>Toko Maju Jaya</x-ui.table.cell>
                                        <x-ui.table.cell><x-ui.badge color="info" size="sm">Dikirim</x-ui.badge></x-ui.table.cell>
                                        <x-ui.table.cell>Rp 1.125.000</x-ui.table.cell>
                                    </x-ui.table.row>
                                </x-ui.table.body>
                            </x-ui.table>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </section>

        <section class="border-b border-border bg-surface-raised">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
                <h2 class="text-2xl font-semibold tracking-tight text-fg">Three steps to ship</h2>
                <p class="mt-2 max-w-2xl text-fg-muted">No runtime package tax. Copy the snippet, wire tokens, deploy.</p>

                <ol class="mt-10 grid gap-8 sm:grid-cols-3">
                    <li class="relative">
                        <p class="text-xs font-semibold tracking-[0.16em] text-brand uppercase">Step 01</p>
                        <h3 class="mt-2 text-lg font-semibold text-fg">Copy snippet or Blade</h3>
                        <p class="mt-2 text-sm text-fg-muted">Grab HTML + Alpine or an <code class="rounded bg-surface-sunken px-1">&lt;x-ui.*&gt;</code> component from the docs.</p>
                    </li>
                    <li class="relative">
                        <p class="text-xs font-semibold tracking-[0.16em] text-brand uppercase">Step 02</p>
                        <h3 class="mt-2 text-lg font-semibold text-fg">Drop theme.css</h3>
                        <p class="mt-2 text-sm text-fg-muted">Import semantic <code class="rounded bg-surface-sunken px-1">--ui-*</code> tokens once. Themes and dark mode swap at runtime.</p>
                    </li>
                    <li class="relative">
                        <p class="text-xs font-semibold tracking-[0.16em] text-brand uppercase">Step 03</p>
                        <h3 class="mt-2 text-lg font-semibold text-fg">Ship</h3>
                        <p class="mt-2 text-sm text-fg-muted">Keep ownership of the markup. Customize freely inside your Laravel app.</p>
                    </li>
                </ol>
            </div>
        </section>

        <section class="border-b border-border">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
                <h2 class="text-2xl font-semibold tracking-tight text-fg">When to choose what</h2>
                <p class="mt-2 max-w-2xl text-fg-muted">
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
                                <x-ui.table.cell>
                                    <span class="font-medium text-fg">Praesepe UI</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    You want copy-paste Blade + Tailwind 4 + Alpine 3 with semantic themes and docs that dogfood the same components.
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    You own the markup. There is no paid component marketplace or Livewire runtime.
                                </x-ui.table.cell>
                            </x-ui.table.row>
                            <x-ui.table.row>
                                <x-ui.table.cell>
                                    <span class="font-medium text-fg">Flux UI</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    Your app is Livewire-first and you want an official, integrated component layer for that stack.
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    Couples UI to Livewire and a commercial product surface.
                                </x-ui.table.cell>
                            </x-ui.table.row>
                            <x-ui.table.row>
                                <x-ui.table.cell>
                                    <span class="font-medium text-fg">shadcn/ui</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    You build in React (or a React-adjacent toolchain) and want copy-paste primitives in that ecosystem.
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    Not a Blade workflow. Requires a JS component tree.
                                </x-ui.table.cell>
                            </x-ui.table.row>
                            <x-ui.table.row>
                                <x-ui.table.cell>
                                    <span class="font-medium text-fg">Penguin UI</span>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    You want Alpine + Tailwind HTML snippets with a broad marketing-site catalog.
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    Less opinionated around Laravel Blade registries, semantic OKLCH themes, and SME ops examples.
                                </x-ui.table.cell>
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
