<div
    x-data="{
        scheme: 'system',
        init() {
            this.scheme = window.PraesepeTheme?.getStoredColorScheme?.() || 'system';
        },
        set(value) {
            this.scheme = value;
            window.PraesepeTheme?.setColorScheme?.(value);
            window.dispatchEvent(new CustomEvent('ui:scheme-changed', { detail: value }));
        }
    }"
    x-on:ui:scheme-changed.window="scheme = $event.detail"
    role="group"
    aria-label="Color scheme"
    class="inline-flex h-8 items-center gap-0.5 rounded-control border border-border bg-surface-sunken p-0.5">
    <button
        type="button"
        x-on:click="set('light')"
        x-bind:aria-pressed="scheme === 'light' ? 'true' : 'false'"
        x-bind:class="scheme === 'light'
            ? 'bg-surface-raised text-fg shadow-2xs border-border/60'
            : 'border-transparent text-fg-muted hover:text-fg'"
        class="inline-flex size-7 items-center justify-center rounded-[calc(var(--radius-control)-2px)] border transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
        aria-label="Light mode"
        title="Light mode">
        <x-icons.sun aria-hidden="true" class="size-3.5 shrink-0" />
    </button>

    <button
        type="button"
        x-on:click="set('dark')"
        x-bind:aria-pressed="scheme === 'dark' ? 'true' : 'false'"
        x-bind:class="scheme === 'dark'
            ? 'bg-surface-raised text-fg shadow-2xs border-border/60'
            : 'border-transparent text-fg-muted hover:text-fg'"
        class="inline-flex size-7 items-center justify-center rounded-[calc(var(--radius-control)-2px)] border transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
        aria-label="Dark mode"
        title="Dark mode">
        <x-icons.moon aria-hidden="true" class="size-3.5 shrink-0" />
    </button>

    <button
        type="button"
        x-on:click="set('system')"
        x-bind:aria-pressed="scheme === 'system' ? 'true' : 'false'"
        x-bind:class="scheme === 'system'
            ? 'bg-surface-raised text-fg shadow-2xs border-border/60'
            : 'border-transparent text-fg-muted hover:text-fg'"
        class="inline-flex size-7 items-center justify-center rounded-[calc(var(--radius-control)-2px)] border transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
        aria-label="System preference"
        title="System preference">
        <svg aria-hidden="true" class="size-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="3" width="20" height="14" rx="2" />
            <path d="M8 21h8" />
            <path d="M12 17v4" />
        </svg>
    </button>
</div>