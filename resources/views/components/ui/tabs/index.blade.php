@props([
    'variant' => 'underline',
    'active' => null,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-tabs-'.Str::random(6));
    $orientation = $variant === 'vertical' ? 'vertical' : 'horizontal';

    $shellClasses = [
        'underline' => 'space-y-4',
        'pills' => 'space-y-4',
        'vertical' => 'flex gap-6',
    ];

    $listClasses = [
        'underline' => 'flex gap-1 border-b border-border',
        'pills' => 'inline-flex flex-wrap gap-1 rounded-control bg-surface-sunken p-1',
        'vertical' => 'flex w-48 shrink-0 flex-col gap-1 border-r border-border pr-4',
    ];

    $shellClass = $shellClasses[$variant] ?? $shellClasses['underline'];
    $listClass = $listClasses[$variant] ?? $listClasses['underline'];
@endphp

<div
    {{ $attributes->except(['id'])->class([$shellClass]) }}
    data-variant="{{ $variant }}"
    x-data="{
        active: @js($active),
        orientation: @js($orientation),
        select(id) {
            const tab = this.$refs.tablist?.querySelector('[role=tab][data-tab-id=\"' + id + '\"]');
            if (tab?.disabled || tab?.getAttribute('aria-disabled') === 'true') return;
            this.active = id;
        },
        tabs() {
            return Array.from(this.$refs.tablist?.querySelectorAll('[role=tab]:not([disabled]):not([aria-disabled=true])') || []);
        },
        focusTab(index) {
            const list = this.tabs();
            if (!list.length) return;
            const next = (index + list.length) % list.length;
            const el = list[next];
            el?.focus();
            const id = el?.getAttribute('data-tab-id');
            if (id) this.select(id);
        },
        onListKeydown(event) {
            const list = this.tabs();
            if (!list.length) return;
            const current = list.indexOf(document.activeElement);
            const horizontal = this.orientation === 'horizontal';
            switch (event.key) {
                case 'ArrowRight':
                    if (!horizontal) return;
                    event.preventDefault();
                    this.focusTab(current + 1);
                    break;
                case 'ArrowLeft':
                    if (!horizontal) return;
                    event.preventDefault();
                    this.focusTab(current - 1);
                    break;
                case 'ArrowDown':
                    if (horizontal) return;
                    event.preventDefault();
                    this.focusTab(current + 1);
                    break;
                case 'ArrowUp':
                    if (horizontal) return;
                    event.preventDefault();
                    this.focusTab(current - 1);
                    break;
                case 'Home':
                    event.preventDefault();
                    this.focusTab(0);
                    break;
                case 'End':
                    event.preventDefault();
                    this.focusTab(list.length - 1);
                    break;
            }
        }
    }"
    x-init="if (!active) { const first = tabs()[0]; if (first) active = first.getAttribute('data-tab-id'); }"
>
    <div
        x-ref="tablist"
        role="tablist"
        aria-orientation="{{ $orientation }}"
        class="{{ $listClass }}"
        x-on:keydown="onListKeydown($event)"
    >
        {{ $list ?? '' }}
    </div>

    <div class="min-w-0 flex-1">
        {{ $slot }}
    </div>
</div>
