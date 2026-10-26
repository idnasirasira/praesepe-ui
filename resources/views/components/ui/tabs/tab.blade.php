@aware(['variant' => 'underline'])

@props([
    'id',
    'disabled' => false,
])

@php
    $variantClasses = [
        'underline' => 'min-h-10 border-b-2 border-transparent px-3 py-2 text-sm font-medium text-fg-muted hover:text-fg data-active:border-brand data-active:text-fg',
        'pills' => 'min-h-9 rounded-control px-3 py-2 text-sm font-medium text-fg-muted hover:text-fg data-active:bg-surface-raised data-active:text-fg data-active:shadow-sm',
        'vertical' => 'min-h-10 rounded-control px-3 py-2.5 text-left text-sm font-medium text-fg-muted hover:bg-surface-sunken hover:text-fg data-active:bg-surface-sunken data-active:text-fg',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['underline'];
@endphp

<button
    type="button"
    role="tab"
    id="{{ $id }}-tab"
    data-tab-id="{{ $id }}"
    x-bind:aria-selected="(active === @js($id)).toString()"
    x-bind:tabindex="active === @js($id) ? 0 : -1"
    x-bind:data-active="active === @js($id) ? '' : null"
    aria-controls="{{ $id }}-panel"
    @if ($disabled) disabled aria-disabled="true" @endif
    {{ $attributes->class([$variantClass, 'outline-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface', $disabled ? 'cursor-not-allowed opacity-50' : '']) }}
    x-on:click="select(@js($id))"
>
    {{ $slot }}
</button>
