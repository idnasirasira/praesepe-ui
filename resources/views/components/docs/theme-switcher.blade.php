<div
    class="relative"
    x-data="{
        open: false,
        theme: window.PraesepeTheme?.getStoredTheme() || 'praesepe',
        themes: [
            { id: 'praesepe', label: 'Praesepe' },
            { id: 'minimal', label: 'Minimal' },
            { id: 'warm', label: 'Warm' },
        ],
        select(id) {
            this.theme = id;
            window.PraesepeTheme?.setTheme(id);
            this.open = false;
        }
    }"
>
    <button
        type="button"
        class="inline-flex items-center gap-1.5 rounded-control border border-border px-2.5 py-1.5 text-xs font-medium text-fg"
        x-on:click="open = !open"
        x-bind:aria-expanded="open.toString()"
        aria-haspopup="listbox"
    >
        <span x-text="themes.find(t => t.id === theme)?.label || 'Theme'"></span>
    </button>
    <ul
        class="absolute right-0 z-50 mt-1 min-w-36 overflow-hidden rounded-control border border-border bg-surface-raised shadow-md"
        x-show="open"
        x-cloak
        x-on:click.outside="open = false"
        role="listbox"
        aria-label="Theme"
    >
        <template x-for="item in themes" x-bind:key="item.id">
            <li>
                <button
                    type="button"
                    class="flex w-full px-3 py-2 text-left text-sm text-fg hover:bg-surface-sunken"
                    x-bind:class="theme === item.id ? 'bg-surface-sunken font-medium' : ''"
                    x-on:click="select(item.id)"
                    role="option"
                    x-bind:aria-selected="(theme === item.id).toString()"
                    x-text="item.label"
                ></button>
            </li>
        </template>
    </ul>
</div>
