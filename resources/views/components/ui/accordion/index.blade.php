@props([
    'type' => 'single',
    'default' => null,
])

@php
    $isMultiple = $type === 'multiple';
    $initial = $isMultiple
        ? (is_array($default) ? array_values($default) : (filled($default) ? [$default] : []))
        : $default;
@endphp

<div
    {{ $attributes->class(['divide-y divide-border rounded-card border border-border bg-surface-raised']) }}
    x-data="{
        type: @js($type),
        openIds: @js($initial),
        isOpen(id) {
            return this.type === 'multiple'
                ? this.openIds.includes(id)
                : this.openIds === id;
        },
        toggle(id) {
            if (this.type === 'multiple') {
                this.openIds = this.openIds.includes(id)
                    ? this.openIds.filter((value) => value !== id)
                    : [...this.openIds, id];
                return;
            }
            this.openIds = this.openIds === id ? null : id;
        }
    }"
>
    {{ $slot }}
</div>
