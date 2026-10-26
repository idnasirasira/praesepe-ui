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
    x-on:ui:search-open.window="openSearch()"
    x-on:keydown.escape.window="if (sidebarOpen && !searchOpen) sidebarOpen = false"
    x-on:resize.window="if (window.innerWidth >= 1280 && sidebarOpen) sidebarOpen = false"
>
    <header class="sticky top-0 z-50 border-b border-border bg-surface/85 backdrop-blur-md">
        <div class="mx-auto flex h-14 max-w-[90rem] items-center gap-3 px-4 sm:px-6 lg:px-8">
            <a
                href="{{ route('home') }}"
                class="inline-flex min-w-0 items-center gap-2.5 rounded-control font-semibold tracking-tight text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            >
                <span class="inline-flex size-7 shrink-0 items-center justify-center rounded-control bg-brand text-xs font-bold text-on-brand shadow-2xs" aria-hidden="true">P</span>
                <span class="truncate">{{ config('ui-docs.name') }}</span>
                <span class="hidden text-xs font-normal tabular-nums text-fg-subtle sm:inline">v{{ config('ui-docs.version') }}</span>
            </a>

            <div class="ml-auto flex items-center gap-1.5 sm:gap-2">
                {{-- Desktop / tablet search --}}
                <button
                    type="button"
                    class="hidden h-9 items-center gap-2 rounded-control border border-border bg-surface-raised px-3 text-sm text-fg-muted shadow-2xs transition-colors duration-150 hover:border-border-strong hover:text-fg md:inline-flex md:min-w-[12rem]"
                    x-on:click="openSearch()"
                >
                    <x-icons.search class="size-3.5 shrink-0" />
                    <span>Search docs</span>
                    <span class="ml-auto inline-flex items-center gap-1">
                        <kbd class="rounded border border-border bg-surface-sunken px-1 py-0.5 text-[10px] tabular-nums text-fg-subtle">/</kbd>
                        <kbd class="rounded border border-border bg-surface-sunken px-1 py-0.5 text-[10px] tabular-nums text-fg-subtle">⌘K</kbd>
                    </span>
                </button>

                {{-- Mobile search icon --}}
                <button
                    type="button"
                    class="inline-flex size-9 items-center justify-center rounded-control border border-border bg-surface-raised text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken md:hidden"
                    x-on:click="$dispatch('ui:search-open')"
                    aria-label="Open search"
                >
                    <x-icons.search class="size-4 shrink-0" />
                </button>

                {{-- Theme controls: tablet+ in top bar --}}
                <div class="hidden items-center gap-1.5 md:flex">
                    <x-docs.theme-switcher />
                    <x-docs.dark-mode-toggle />
                </div>

                {{-- Mobile / tablet menu until desktop sidebar --}}
                <button
                    type="button"
                    class="inline-flex size-9 items-center justify-center rounded-control border border-border bg-surface-raised text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken xl:hidden"
                    x-on:click="sidebarOpen = !sidebarOpen"
                    x-bind:aria-expanded="sidebarOpen.toString()"
                    aria-controls="docs-mobile-drawer"
                    aria-label="Open navigation menu"
                >
                    <svg
                        x-show="!sidebarOpen"
                        aria-hidden="true"
                        class="size-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.75"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 7h16" />
                        <path d="M4 12h16" />
                        <path d="M4 17h12" />
                    </svg>
                    <svg
                        x-show="sidebarOpen"
                        x-cloak
                        aria-hidden="true"
                        class="size-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.75"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Teleported mobile drawer (avoids backdrop-blur stacking bugs) --}}
    <template x-teleport="body">
        <div
            x-show="sidebarOpen"
            x-cloak
            id="docs-mobile-drawer"
            role="dialog"
            aria-modal="true"
            aria-label="Documentation navigation"
            class="fixed inset-0 z-50 xl:hidden"
        >
            <div
                x-show="sidebarOpen"
                x-transition:enter="transition-opacity ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click="sidebarOpen = false"
                aria-hidden="true"
                class="fixed inset-0 bg-overlay backdrop-blur-[2px]"
            ></div>

            <div
                x-show="sidebarOpen"
                x-trap.inert.noscroll="sidebarOpen"
                x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-150 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative flex h-full w-[min(20rem,calc(100vw-2.5rem))] flex-col border-r border-border bg-surface-raised shadow-xl"
            >
                <div class="flex h-14 shrink-0 items-center justify-between border-b border-border px-4">
                    <span class="text-sm font-semibold tracking-tight text-fg">{{ config('ui-docs.name') }}</span>
                    <button
                        type="button"
                        x-on:click="sidebarOpen = false"
                        class="inline-flex size-9 items-center justify-center rounded-control text-fg-muted transition-colors duration-150 hover:bg-surface-sunken hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        aria-label="Close navigation menu"
                    >
                        <x-icons.x class="size-4 shrink-0" />
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto overscroll-contain px-3 py-4">
                    <x-docs.nav :grouped-components="$groupedComponents" compact />
                </div>

                <div class="shrink-0 space-y-3 border-t border-border bg-surface p-4">
                    <div class="flex items-center gap-2">
                        <x-docs.theme-switcher />
                        <x-docs.dark-mode-toggle />
                    </div>
                    @if (config('ui-docs.github_url'))
                        <a
                            href="{{ config('ui-docs.github_url') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-control border border-border bg-surface-raised text-sm font-medium text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >
                            GitHub
                        </a>
                    @endif
                    @if (config('ui-docs.whatsapp_url'))
                        <x-ui.button size="sm" class="w-full justify-center" :href="config('ui-docs.whatsapp_url')" target="_blank" rel="noopener noreferrer">
                            Built by Praesepe
                        </x-ui.button>
                    @elseif (config('ui-docs.email'))
                        <x-ui.button size="sm" class="w-full justify-center" variant="outline" :href="'mailto:'.config('ui-docs.email')">
                            Built by Praesepe
                        </x-ui.button>
                    @else
                        <x-ui.button size="sm" class="w-full justify-center" variant="outline" :href="config('ui-docs.praesepe_url')" target="_blank" rel="noopener noreferrer">
                            Built by Praesepe
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </template>

    <div class="mx-auto flex max-w-[90rem]">
        <aside
            id="docs-sidebar"
            class="sticky top-14 z-30 hidden h-[calc(100dvh-3.5rem)] w-72 shrink-0 self-start overflow-y-auto border-r border-border bg-surface px-4 py-8 xl:block"
        >
            <x-docs.nav :grouped-components="$groupedComponents" />
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
