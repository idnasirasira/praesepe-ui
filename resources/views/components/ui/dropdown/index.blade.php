@props([
    'align' => 'left',
    'label' => 'Open menu',
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-dropdown-'.Str::random(6));
    $menuId = $id.'-menu';

    $alignClasses = [
        'left' => 'left-0 origin-top-left',
        'right' => 'right-0 origin-top-right',
    ];

    $alignClass = $alignClasses[$align] ?? $alignClasses['left'];
@endphp

<div
    {{ $attributes->except(['id'])->class(['relative inline-block text-left']) }}
    x-data="{
        open: false,
        menuId: @js($menuId),
        triggerEl: null,
        items() {
            return Array.from(this.$refs.menu?.querySelectorAll('[role=menuitem]:not([disabled]):not([aria-disabled=true])') || []);
        },
        show() {
            this.triggerEl = this.$refs.trigger;
            this.open = true;
            this.$nextTick(() => this.focusItem(0));
        },
        hide(restoreFocus = true) {
            this.open = false;
            if (restoreFocus) {
                this.$nextTick(() => this.triggerEl?.focus());
            }
        },
        toggle() {
            this.open ? this.hide() : this.show();
        },
        focusItem(index) {
            const list = this.items();
            if (!list.length) return;
            const next = (index + list.length) % list.length;
            list[next]?.focus();
        },
        focusByOffset(offset) {
            const list = this.items();
            if (!list.length) return;
            const active = document.activeElement;
            const current = list.indexOf(active);
            const start = current === -1 ? (offset > 0 ? -1 : 0) : current;
            this.focusItem(start + offset);
        },
        onMenuKeydown(event) {
            if (!this.open) return;
            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    this.focusByOffset(1);
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.focusByOffset(-1);
                    break;
                case 'Home':
                    event.preventDefault();
                    this.focusItem(0);
                    break;
                case 'End':
                    event.preventDefault();
                    this.focusItem(this.items().length - 1);
                    break;
                case 'Escape':
                    event.preventDefault();
                    this.hide(true);
                    break;
                case 'Tab':
                    this.hide(false);
                    break;
            }
        }
    }"
    x-on:keydown="onMenuKeydown($event)"
    x-on:click.outside="if (open) hide(false)"
>
    <button
        type="button"
        x-ref="trigger"
        id="{{ $id }}-trigger"
        class="inline-flex items-center gap-2 rounded-control border border-border bg-surface-raised px-3 py-2 text-sm font-medium text-fg shadow-sm hover:bg-surface-sunken"
        aria-haspopup="menu"
        x-bind:aria-expanded="open.toString()"
        x-bind:aria-controls="menuId"
        x-on:click="toggle()"
        x-on:keydown.arrow-down.prevent="show()"
    >
        @isset($trigger)
            {{ $trigger }}
        @else
            {{ $label }}
            <x-icons.chevron-down class="size-4 text-fg-subtle" />
        @endisset
    </button>

    <div
        x-ref="menu"
        id="{{ $menuId }}"
        role="menu"
        aria-labelledby="{{ $id }}-trigger"
        x-show="open"
        x-cloak
        x-transition.origin.top
        class="absolute z-40 mt-2 min-w-48 rounded-card border border-border bg-surface-raised p-1 shadow-lg {{ $alignClass }}"
        x-bind:aria-hidden="(!open).toString()"
    >
        {{ $slot }}
    </div>
</div>
