@php
    $askHref = config('ui-docs.whatsapp_url')
        ?: (config('ui-docs.email') ? 'mailto:'.config('ui-docs.email') : config('ui-docs.praesepe_url'));
    $askExternal = ! str_starts_with((string) $askHref, 'mailto:');
@endphp

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
            <x-icons.search class="size-4 shrink-0 text-fg-subtle" aria-hidden="true" />
            <input
                type="text"
                x-ref="searchInput"
                x-model="query"
                x-on:input="runSearch()"
                x-on:keydown="onComboboxKeydown($event)"
                role="combobox"
                aria-autocomplete="list"
                aria-controls="search-results"
                x-bind:aria-expanded="searchOpen.toString()"
                x-bind:aria-activedescendant="activeOptionId()"
                placeholder="Search components, props, variants, and docs"
                aria-label="Search components, props, variants, and docs"
                class="w-full border-0 bg-transparent py-3 text-sm text-fg outline-none placeholder:text-fg-subtle"
            >
            <button type="button" class="shrink-0 text-xs text-fg-subtle" x-on:click="closeSearch()">Esc</button>
        </div>

        <div id="search-results" class="max-h-80 overflow-y-auto p-2" role="listbox" aria-label="Search results">
            <template x-if="!query && recent.length">
                <div class="mb-2">
                    <p class="px-3 py-1 text-xs font-semibold uppercase tracking-wide text-fg-subtle">Recent</p>
                    <ul class="space-y-0.5">
                        <template x-for="(item, index) in recent" x-bind:key="'recent-' + item.href">
                            <li>
                                <button
                                    type="button"
                                    class="flex w-full flex-col rounded-control px-3 py-2 text-left hover:bg-surface-sunken"
                                    x-on:click="goTo(item)"
                                >
                                    <span class="text-sm font-medium text-fg" x-text="item.title"></span>
                                    <span class="text-xs text-fg-muted" x-text="item.description"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>

            <template x-for="(result, index) in results" x-bind:key="result.href">
                <div
                    x-bind:id="'search-option-' + index"
                    role="option"
                    x-bind:aria-selected="(activeIndex === index).toString()"
                    class="rounded-control px-3 py-2"
                    x-bind:class="activeIndex === index ? 'bg-surface-sunken' : 'hover:bg-surface-sunken'"
                    x-on:mouseenter="activeIndex = index"
                    x-on:click="goTo(result)"
                >
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-fg" x-text="result.title"></span>
                        <span class="rounded border border-border px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-fg-subtle" x-text="result.type"></span>
                    </div>
                    <div class="text-xs text-fg-muted" x-text="result.description"></div>
                </div>
            </template>

            <div x-show="query && results.length === 0" class="px-3 py-6 text-center" x-cloak>
                <p class="text-sm text-fg-muted">No results for "<span x-text="query"></span>".</p>
                <a
                    href="{{ $askHref }}"
                    class="mt-4 inline-flex items-center justify-center rounded-control bg-brand px-4 py-2 text-sm font-medium text-on-brand"
                    @if ($askExternal) rel="noopener noreferrer" target="_blank" @endif
                    x-on:click="closeSearch()"
                >
                    No results? Ask Praesepe to build it
                </a>
            </div>

            <p x-show="!query && !recent.length" class="px-3 py-6 text-center text-sm text-fg-muted" x-cloak>
                Type to search components, props, variants, and docs headings.
            </p>
        </div>
    </div>
</div>
