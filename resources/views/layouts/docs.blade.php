@extends('layouts.app')

@section('body')
<div
    class="min-h-dvh"
    x-data="{
        sidebarOpen: false,
        searchOpen: false,
        query: '',
        results: [],
        index: [],
        async loadIndex() {
            if (this.index.length) return;
            try {
                const response = await fetch(@js(route('search-index')));
                const data = await response.json();
                this.index = data.entries || [];
            } catch (e) {
                this.index = [];
            }
        },
        openSearch() {
            this.searchOpen = true;
            this.loadIndex();
            this.$nextTick(() => this.$refs.searchInput?.focus());
        },
        closeSearch() {
            this.searchOpen = false;
            this.query = '';
            this.results = [];
        },
        runSearch() {
            const q = this.query.trim().toLowerCase();
            if (!q) {
                this.results = [];
                return;
            }
            this.results = this.index.filter((entry) => {
                const hay = [entry.title, entry.description, ...(entry.tags || [])].join(' ').toLowerCase();
                return hay.includes(q);
            }).slice(0, 12);
        },
        openSearchFromSlash(event) {
            if (event.key !== '/' || this.searchOpen) {
                return;
            }

            const target = event.target;
            if (!(target instanceof Element)) {
                return;
            }

            const tag = target.tagName;
            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(tag) || target.isContentEditable) {
                return;
            }

            event.preventDefault();
            this.openSearch();
        }
    }"
    x-on:keydown.window.prevent.cmd.k="openSearch()"
    x-on:keydown.window.prevent.ctrl.k="openSearch()"
    x-on:keydown.window="openSearchFromSlash($event)"
>
    <header class="sticky top-0 z-40 border-b border-border bg-surface/90 backdrop-blur">
        <div class="mx-auto flex h-14 max-w-7xl items-center gap-3 px-4 sm:px-6 lg:px-8">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-control border border-border p-2 text-fg lg:hidden"
                x-on:click="sidebarOpen = !sidebarOpen"
                x-bind:aria-expanded="sidebarOpen.toString()"
                aria-controls="docs-sidebar"
            >
                <span class="sr-only">Toggle navigation</span>
                <x-icons.menu class="size-5" />
            </button>

            <a href="{{ route('home') }}" class="font-semibold tracking-tight text-fg">
                {{ config('ui-docs.name') }}
                <span class="ml-2 text-xs font-normal text-fg-subtle">v{{ config('ui-docs.version') }}</span>
            </a>

            <div class="ml-auto flex items-center gap-2">
                <button
                    type="button"
                    class="hidden items-center gap-2 rounded-control border border-border px-3 py-1.5 text-sm text-fg-muted sm:inline-flex"
                    x-on:click="openSearch()"
                >
                    <x-icons.search class="size-4" />
                    <span>Search</span>
                    <kbd class="rounded border border-border px-1 text-[10px] text-fg-subtle">⌘K</kbd>
                </button>

                <x-docs.theme-switcher />
                <x-docs.dark-mode-toggle />
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl">
        <div
            class="fixed inset-0 z-30 bg-fg/40 lg:hidden"
            x-show="sidebarOpen"
            x-cloak
            x-on:click="sidebarOpen = false"
        ></div>

        <aside
            id="docs-sidebar"
            class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full overflow-y-auto border-r border-border bg-surface px-4 py-6 transition-transform lg:static lg:translate-x-0 lg:pt-8"
            x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <nav aria-label="Documentation" class="space-y-6">
                @foreach (config('ui-docs.navigation') as $group)
                    <div>
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-fg-subtle">{{ $group['label'] }}</p>
                        <ul class="space-y-1">
                            @foreach ($group['items'] as $item)
                                <li>
                                    <a
                                        href="{{ route($item['route']) }}"
                                        @class([
                                            'block rounded-control px-3 py-2 text-sm',
                                            'bg-surface-sunken font-medium text-fg' => request()->routeIs($item['route']),
                                            'text-fg-muted hover:bg-surface-sunken hover:text-fg' => ! request()->routeIs($item['route']),
                                        ])
                                    >
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                @php($components = app(\App\Docs\ComponentRegistry::class)->all())
                @if (count($components) > 0)
                    <div>
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-fg-subtle">Library</p>
                        <ul class="space-y-1">
                            @foreach ($components as $component)
                                <li>
                                    <a
                                        href="{{ route('docs.components.show', $component->slug) }}"
                                        @class([
                                            'block rounded-control px-3 py-2 text-sm',
                                            'bg-surface-sunken font-medium text-fg' => request()->routeIs('docs.components.show') && request()->route('slug') === $component->slug,
                                            'text-fg-muted hover:bg-surface-sunken hover:text-fg' => ! (request()->routeIs('docs.components.show') && request()->route('slug') === $component->slug),
                                        ])
                                    >
                                        {{ $component->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </nav>
        </aside>

        <div class="min-w-0 flex-1">
            <main id="main-content" class="px-4 py-8 sm:px-6 lg:px-10">
                @yield('content')
            </main>
            <x-docs.footer />
        </div>
    </div>

    <div
        class="fixed inset-0 z-50 flex items-start justify-center bg-fg/50 p-4 pt-[12vh]"
        x-show="searchOpen"
        x-cloak
        x-on:keydown.escape.window="if (searchOpen) closeSearch()"
        x-on:click.self="closeSearch()"
        role="dialog"
        aria-modal="true"
        aria-label="Search documentation"
        x-trap.inert.noscroll="searchOpen"
    >
        <div class="w-full max-w-xl overflow-hidden rounded-card border border-border bg-surface-raised shadow-lg">
            <div class="flex items-center gap-2 border-b border-border px-3">
                <x-icons.search class="size-4 text-fg-subtle" aria-hidden="true" />
                <input
                    type="search"
                    x-ref="searchInput"
                    x-model="query"
                    x-on:input="runSearch()"
                    placeholder="Search components and docs"
                    aria-label="Search components and docs"
                    class="w-full border-0 bg-transparent py-3 text-sm text-fg outline-none placeholder:text-fg-subtle"
                >
                <button type="button" class="text-xs text-fg-subtle" x-on:click="closeSearch()">Esc</button>
            </div>
            <ul class="max-h-80 overflow-y-auto p-2" role="listbox">
                <template x-for="result in results" x-bind:key="result.href">
                    <li>
                        <a
                            x-bind:href="result.href"
                            class="block rounded-control px-3 py-2 hover:bg-surface-sunken"
                            x-on:click="closeSearch()"
                        >
                            <div class="text-sm font-medium text-fg" x-text="result.title"></div>
                            <div class="text-xs text-fg-muted" x-text="result.description"></div>
                        </a>
                    </li>
                </template>
                <li x-show="query && results.length === 0" class="px-3 py-6 text-center text-sm text-fg-muted">
                    No results
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
