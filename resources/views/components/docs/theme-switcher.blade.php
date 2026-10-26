<div
    class="relative"
    x-data="{
        open: false,
        theme: window.PraesepeTheme?.getStoredTheme() || 'praesepe',
        themes: [
            { id: 'praesepe', label: 'Praesepe', brand: 'oklch(0.46 0.17 278)', surface: 'oklch(0.985 0.006 268)' },
            { id: 'minimal', label: 'Minimal', brand: 'oklch(0.16 0 0)', surface: 'oklch(0.995 0 0)' },
            { id: 'warm', label: 'Warm', brand: 'oklch(0.46 0.09 195)', surface: 'oklch(0.975 0.012 80)' },
        ],
        select(id) {
            this.theme = id;
            window.PraesepeTheme?.setTheme(id);
            this.open = false;
        },
        current() {
            return this.themes.find((item) => item.id === this.theme) || this.themes[0];
        }
    }"
>
    <button
        type="button"
        class="inline-flex h-8 items-center gap-2 rounded-pill border border-border bg-surface-raised px-2.5 text-xs font-medium text-fg shadow-2xs transition-colors duration-150 hover:border-border-strong hover:bg-surface-sunken"
        x-on:click="open = !open"
        x-bind:aria-expanded="open.toString()"
        aria-haspopup="listbox"
        aria-label="Theme switcher"
    >
        <span class="flex items-center -space-x-1" aria-hidden="true">
            <template x-for="item in themes" x-bind:key="item.id">
                <span
                    class="size-3 rounded-full ring-1 ring-border ring-offset-1 ring-offset-surface"
                    x-bind:style="'background:' + item.brand"
                    x-bind:class="theme === item.id ? 'z-10 ring-brand' : 'opacity-70'"
                ></span>
            </template>
        </span>
        <span class="hidden sm:inline" x-text="current().label"></span>
        <x-icons.chevron-down class="size-3.5 shrink-0 text-fg-subtle" />
    </button>

    <ul
        class="absolute right-0 z-50 mt-2 min-w-48 overflow-hidden rounded-card border border-border bg-surface-raised p-1 shadow-lg ring-1 ring-black/5"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-on:click.outside="open = false"
        role="listbox"
        aria-label="Theme"
    >
        <template x-for="item in themes" x-bind:key="item.id">
            <li>
                <button
                    type="button"
                    class="flex w-full items-center gap-2.5 rounded-control px-2.5 py-2 text-left text-sm text-fg hover:bg-surface-sunken"
                    x-bind:class="theme === item.id ? 'bg-brand/10 font-medium text-brand' : ''"
                    x-on:click="select(item.id)"
                    role="option"
                    x-bind:aria-selected="(theme === item.id).toString()"
                >
                    <span class="flex size-6 items-center justify-center overflow-hidden rounded-control border border-border" aria-hidden="true">
                        <span class="h-full w-1/2" x-bind:style="'background:' + item.brand"></span>
                        <span class="h-full w-1/2" x-bind:style="'background:' + item.surface"></span>
                    </span>
                    <span x-text="item.label"></span>
                </button>
            </li>
        </template>
    </ul>
</div>
