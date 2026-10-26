<div
    x-data="{
        scheme: window.PraesepeTheme?.getStoredColorScheme() || 'system',
        cycle() {
            const order = ['light', 'dark', 'system'];
            const next = order[(order.indexOf(this.scheme) + 1) % order.length];
            this.scheme = next;
            window.PraesepeTheme?.setColorScheme(next);
        },
        label() {
            if (this.scheme === 'light') return 'Light';
            if (this.scheme === 'dark') return 'Dark';
            return 'System';
        }
    }"
>
    <button
        type="button"
        class="inline-flex size-8 items-center justify-center rounded-control border border-border bg-surface-raised text-fg shadow-2xs transition-colors duration-150 hover:border-border-strong hover:bg-surface-sunken"
        x-on:click="cycle()"
        x-bind:aria-label="'Color scheme: ' + label()"
        title="Toggle color scheme"
    >
        <span x-show="scheme === 'light'"><x-icons.sun class="size-4 shrink-0" /></span>
        <span x-show="scheme === 'dark'" x-cloak><x-icons.moon class="size-4 shrink-0" /></span>
        <span x-show="scheme === 'system'" x-cloak class="text-[10px] font-semibold tracking-wide">SYS</span>
    </button>
</div>
