@props([
    'variant' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $variantClasses = [
        'info' => 'border-info/30 bg-info-soft text-fg',
        'success' => 'border-success/30 bg-success-soft text-fg',
        'warning' => 'border-warning/30 bg-warning-soft text-fg',
        'danger' => 'border-danger/30 bg-danger-soft text-fg',
    ];

    $iconClasses = [
        'info' => 'text-info',
        'success' => 'text-success',
        'warning' => 'text-warning',
        'danger' => 'text-danger',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['info'];
    $iconClass = $iconClasses[$variant] ?? $iconClasses['info'];
    $role = $variant === 'danger' ? 'alert' : 'status';
@endphp

<div
    @if ($dismissible)
        x-data="{ show: true }"
        x-show="show"
        x-cloak
    @endif
    {{ $attributes->class(['flex gap-3 rounded-card border p-4 shadow-sm', $variantClass]) }}
    role="{{ $role }}"
>
    <span class="mt-0.5 shrink-0 {{ $iconClass }}">
        @if ($variant === 'success')
            <x-icons.check class="size-5" />
        @elseif ($variant === 'warning' || $variant === 'danger')
            <x-icons.alert class="size-5" />
        @else
            <x-icons.info class="size-5" />
        @endif
    </span>

    <div class="min-w-0 flex-1">
        @if ($title)
            <p class="text-sm font-semibold text-fg">{{ $title }}</p>
        @endif
        <div @class(['text-sm text-fg-muted', 'mt-1' => filled($title)])>
            {{ $slot }}
        </div>
    </div>

    @if ($dismissible)
        <button
            type="button"
            class="shrink-0 rounded-control p-1 text-fg-muted hover:bg-surface/50 hover:text-fg"
            x-on:click="show = false"
            aria-label="Dismiss alert"
        >
            <x-icons.x class="size-4" />
        </button>
    @endif
</div>
