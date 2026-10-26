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
        menuStyle: {},
        items() {
            return Array.from(this.$refs.menu?.querySelectorAll('[role=menuitem]:not([disabled]):not([aria-disabled=true])') || []);
        },
        place() {
            const trigger = this.$refs.trigger;
            if (! trigger) {
                return;
            }

            const rect = trigger.getBoundingClientRect();
            const gap = 8;
            const top = rect.bottom + gap;
            const left = this.alignRight()
                ? Math.max(8, rect.right - Math.max(this.$refs.menu?.offsetWidth || 192, 192))
                : Math.min(rect.left, window.innerWidth - 200);

            this.menuStyle = {
                position: 'fixed',
                top: top + 'px',
                left: left + 'px',
                minWidth: Math.max(rect.width, 192) + 'px',
            };
        },
        alignRight() {
            return @js($align) === 'right';
        },
        show() {
            this.triggerEl = this.$refs.trigger;
            this.open = true;
            this.$nextTick(() => {
                this.place();
                this.focusItem(0);
            });
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
        focusByTypeahead(char) {
            const list = this.items();
            if (!list.length || !char) return;
            const needle = char.toLowerCase();
            const active = document.activeElement;
            const current = list.indexOf(active);
            const ordered = list.slice(current + 1).concat(list.slice(0, current + 1));
            const match = ordered.find((el) => (el.textContent || '').trim().toLowerCase().startsWith(needle));
            match?.focus();
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
                default:
                    if (event.key.length === 1 && !event.ctrlKey && !event.metaKey && !event.altKey) {
                        event.preventDefault();
                        this.focusByTypeahead(event.key);
                    }
                    break;
            }
        }
    }"
    x-on:keydown="onMenuKeydown($event)"
    x-on:click.window="
        if (!open) return;
        const target = $event.target;
        if ($refs.trigger?.contains(target) || $refs.menu?.contains(target)) return;
        hide(false);
    "
    x-on:scroll.window="if (open) place()"
    x-on:resize.window="if (open) place()"
>
    <button
        type="button"
        x-ref="trigger"
        id="{{ $id }}-trigger"
        class="inline-flex h-9 items-center gap-2 rounded-control border border-border bg-surface-raised px-3.5 text-sm font-medium text-fg shadow-2xs transition-colors duration-150 hover:border-border-strong hover:bg-surface-sunken motion-safe:active:translate-y-px focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface [&_svg]:size-4 [&_svg]:shrink-0"
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

    <template x-teleport="body">
        <div
            x-ref="menu"
            id="{{ $menuId }}"
            role="menu"
            aria-labelledby="{{ $id }}-trigger"
            x-show="open"
            x-cloak
            x-bind:style="menuStyle"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95 translate-y-0.5"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-0.5"
            class="z-[55] min-w-48 rounded-card border border-border bg-surface-raised p-1 shadow-lg ring-1 ring-border/60 {{ $alignClass }}"
            x-bind:aria-hidden="(!open).toString()"
        >
            {{ $slot }}
        </div>
    </template>
</div>
