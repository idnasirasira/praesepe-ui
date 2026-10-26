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
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-0.5"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    @endif
    {{ $attributes->class(['flex gap-3 rounded-card border p-4 shadow-2xs', $variantClass]) }}
    role="{{ $role }}"
>
    <span class="mt-0.5 shrink-0 {{ $iconClass }}">
        @if ($variant === 'success')
            <x-icons.check class="size-5 shrink-0" />
        @elseif ($variant === 'warning' || $variant === 'danger')
            <x-icons.alert class="size-5 shrink-0" />
        @else
            <x-icons.info class="size-5 shrink-0" />
        @endif
    </span>

    <div class="min-w-0 flex-1">
        @if ($title)
            <p class="text-sm font-semibold tracking-tight text-fg">{{ $title }}</p>
        @endif
        <div @class(['text-sm text-fg-muted leading-relaxed', 'mt-1' => filled($title)])>
            {{ $slot }}
        </div>
    </div>

    @if ($dismissible)
        <button
            type="button"
            class="inline-flex size-10 shrink-0 items-center justify-center rounded-control text-fg-muted transition-colors duration-150 hover:bg-surface/50 hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            x-on:click="show = false"
            aria-label="Dismiss alert"
        >
            <x-icons.x class="size-4 shrink-0" />
        </button>
    @endif
</div>
