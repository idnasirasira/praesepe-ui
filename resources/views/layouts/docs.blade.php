@extends('layouts.app')

@php
    $registry = app(\App\Docs\ComponentRegistry::class);
    $allComponents = $registry->all();
    $componentGroups = [
        'Actions & Inputs' => ['actions', 'forms'],
        'Overlays & Navigation' => ['overlays', 'navigation', 'disclosure'],
        'Data Display & Layout' => ['data-display', 'layout', 'feedback'],
    ];
    $groupedComponents = [];
    foreach ($componentGroups as $label => $categories) {
        $items = array_values(array_filter(
            $allComponents,
            static fn (\App\Docs\ComponentPage $page): bool => in_array($page->category, $categories, true),
        ));
        if (count($items) > 0) {
            $groupedComponents[$label] = $items;
        }
    }
@endphp

@section('body')
<div
    class="min-h-dvh"
    x-data="commandPalette(@js(route('search-index')))"
    x-on:keydown.window.prevent.cmd.k="openSearch()"
    x-on:keydown.window.prevent.ctrl.k="openSearch()"
    x-on:keydown.window="openSearchFromSlash($event)"
>
    <header class="sticky top-0 z-50 border-b border-border bg-surface/80 backdrop-blur-md">
        <div class="mx-auto flex h-14 max-w-[90rem] items-center gap-3 px-4 sm:px-6 lg:px-8">
            <button
                type="button"
                class="inline-flex size-9 items-center justify-center rounded-control border border-border bg-surface-raised text-fg shadow-2xs xl:hidden"
                x-on:click="sidebarOpen = !sidebarOpen"
                x-bind:aria-expanded="sidebarOpen.toString()"
                aria-controls="docs-sidebar"
            >
                <span class="sr-only">Toggle navigation</span>
                <x-icons.menu class="size-5 shrink-0" />
            </button>

            <a href="{{ route('home') }}" class="font-semibold tracking-tight text-fg">
                {{ config('ui-docs.name') }}
                <span class="ml-2 text-xs font-normal tabular-nums text-fg-subtle">v{{ config('ui-docs.version') }}</span>
            </a>

            <div class="ml-auto flex items-center gap-2">
                <button
                    type="button"
                    class="inline-flex h-8 items-center gap-2 rounded-control border border-border bg-surface-raised px-2.5 text-sm text-fg-muted shadow-2xs transition-colors duration-150 hover:border-border-strong hover:text-fg sm:min-w-[12rem] sm:px-3"
                    x-on:click="openSearch()"
                >
                    <x-icons.search class="size-3.5 shrink-0" />
                    <span class="hidden sm:inline">Search docs</span>
                    <span class="ml-auto hidden items-center gap-1 sm:inline-flex">
                        <kbd class="rounded border border-border bg-surface-sunken px-1 py-0.5 text-[10px] tabular-nums text-fg-subtle">/</kbd>
                        <kbd class="rounded border border-border bg-surface-sunken px-1 py-0.5 text-[10px] tabular-nums text-fg-subtle">⌘K</kbd>
                    </span>
                </button>

                <x-docs.theme-switcher />
                <x-docs.dark-mode-toggle />
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-[90rem]">
        <div
            class="fixed inset-0 z-40 bg-overlay backdrop-blur-[2px] xl:hidden"
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-on:click="sidebarOpen = false"
        ></div>

        <aside
            id="docs-sidebar"
            class="fixed top-14 bottom-0 left-0 z-40 w-72 -translate-x-full overflow-y-auto border-r border-border bg-surface px-4 py-6 transition-transform xl:sticky xl:top-14 xl:z-30 xl:h-[calc(100dvh-3.5rem)] xl:translate-x-0 xl:self-start xl:pt-8"
            x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full xl:translate-x-0'"
        >
            <nav aria-label="Documentation" class="space-y-7">
                @foreach (config('ui-docs.navigation') as $group)
                    <div>
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-fg-subtle">{{ $group['label'] }}</p>
                        <ul class="space-y-0.5">
                            @foreach ($group['items'] as $item)
                                @php($isActive = request()->routeIs($item['route']))
                                <li>
                                    <a
                                        href="{{ route($item['route']) }}"
                                        @class([
                                            'block border-l-2 px-3 py-2 text-sm transition-colors duration-150',
                                            'border-brand bg-brand/10 font-medium text-brand' => $isActive,
                                            'border-transparent text-fg-muted hover:border-border-strong hover:bg-surface-sunken hover:text-fg' => ! $isActive,
                                        ])
                                    >
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                @foreach ($groupedComponents as $groupLabel => $components)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-fg-subtle">{{ $groupLabel }}</p>
                            <span class="rounded-pill bg-surface-sunken px-1.5 py-0.5 text-[10px] font-medium tabular-nums text-fg-muted">{{ count($components) }}</span>
                        </div>
                        <ul class="space-y-0.5">
                            @foreach ($components as $component)
                                @php($isActive = request()->routeIs('docs.components.show') && request()->route('slug') === $component->slug)
                                <li>
                                    <a
                                        href="{{ route('docs.components.show', $component->slug) }}"
                                        @class([
                                            'flex items-center justify-between gap-2 border-l-2 px-3 py-2 text-sm transition-colors duration-150',
                                            'border-brand bg-brand/10 font-medium text-brand' => $isActive,
                                            'border-transparent text-fg-muted hover:border-border-strong hover:bg-surface-sunken hover:text-fg' => ! $isActive,
                                        ])
                                    >
                                        <span>{{ $component->name }}</span>
                                        <span class="rounded-pill bg-surface-sunken px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wide text-fg-subtle">{{ $component->category }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1">
            <div class="min-w-0 flex-1">
                <main id="main-content" class="px-4 py-8 sm:px-6 lg:px-8 xl:px-10">
                    @yield('content')
                </main>
                <x-docs.footer />
            </div>

            <aside class="hidden w-64 shrink-0 xl:block">
                <div class="sticky top-14 h-[calc(100dvh-3.5rem)] space-y-6 overflow-y-auto border-l border-border px-5 py-8">
                    @hasSection('toc')
                        @yield('toc')
                    @else
                        <x-docs.toc :items="[]" />
                    @endif

                    <div class="rounded-card border border-border bg-surface-sunken/60 p-4 ring-1 ring-black/5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-fg-subtle">Studio</p>
                        <p class="mt-2 text-sm font-semibold tracking-tight text-fg">Need custom ERP / SME software?</p>
                        <p class="mt-1.5 text-xs text-fg-muted leading-relaxed text-pretty">
                            Praesepe ships inventory, invoicing, and ops dashboards with these same primitives.
                        </p>
                        <div class="mt-3">
                            @if (config('ui-docs.whatsapp_url'))
                                <x-ui.button size="sm" class="w-full" :href="config('ui-docs.whatsapp_url')" target="_blank" rel="noopener noreferrer">
                                    Chat on WhatsApp
                                </x-ui.button>
                            @elseif (config('ui-docs.email'))
                                <x-ui.button size="sm" class="w-full" :href="'mailto:'.config('ui-docs.email')">
                                    Email the studio
                                </x-ui.button>
                            @else
                                <x-ui.button size="sm" class="w-full" variant="outline" :href="config('ui-docs.praesepe_url')" target="_blank" rel="noopener noreferrer">
                                    Visit Praesepe
                                </x-ui.button>
                            @endif
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <x-docs.command-palette />
</div>
@endsection
