@props([
    'variant' => 'soft',
    'color' => 'neutral',
    'size' => 'md',
    'dot' => false,
    'removable' => false,
])

@php
    $toneClasses = [
        'solid-neutral' => 'bg-fg text-fg-inverse',
        'solid-brand' => 'bg-brand text-on-brand',
        'solid-success' => 'bg-success text-on-success',
        'solid-warning' => 'bg-warning text-on-warning',
        'solid-danger' => 'bg-danger text-on-danger',
        'solid-info' => 'bg-info text-on-info',
        'soft-neutral' => 'bg-surface-sunken text-fg',
        'soft-brand' => 'bg-brand/10 text-brand',
        'soft-success' => 'bg-success-soft text-success',
        'soft-warning' => 'bg-warning-soft text-warning',
        'soft-danger' => 'bg-danger-soft text-danger',
        'soft-info' => 'bg-info-soft text-info',
        'outline-neutral' => 'border border-border-strong bg-transparent text-fg',
        'outline-brand' => 'border border-brand bg-transparent text-brand',
        'outline-success' => 'border border-success bg-transparent text-success',
        'outline-warning' => 'border border-warning bg-transparent text-warning',
        'outline-danger' => 'border border-danger bg-transparent text-danger',
        'outline-info' => 'border border-info bg-transparent text-info',
    ];

    $dotClasses = [
        'neutral' => 'bg-fg-muted',
        'brand' => 'bg-brand',
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-danger',
        'info' => 'bg-info',
    ];

    $sizeClasses = [
        'sm' => 'gap-1 px-1.5 py-0.5 text-[11px] tabular-nums',
        'md' => 'gap-1.5 px-2 py-0.5 text-xs tabular-nums',
    ];

    $toneKey = $variant.'-'.$color;
    $toneClass = $toneClasses[$toneKey] ?? $toneClasses['soft-neutral'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $dotClass = $dotClasses[$color] ?? $dotClasses['neutral'];
    $actionAttributes = $attributes->whereStartsWith(['x-on:', 'wire:']);
    $wrapperAttributes = $attributes->whereDoesntStartWith(['x-on:', 'wire:']);
@endphp

<span
    {{ $wrapperAttributes->class([
        'inline-flex items-center rounded-pill font-medium shadow-2xs',
        $toneClass,
        $sizeClass,
    ]) }}
>
    @if ($dot)
        <span class="size-1.5 shrink-0 rounded-full {{ $dotClass }}" aria-hidden="true"></span>
    @endif

    <span>{{ $slot }}</span>

    @if ($removable)
        <button
            type="button"
            class="-mr-0.5 inline-flex size-6 shrink-0 items-center justify-center rounded-full opacity-80 transition-opacity hover:opacity-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-1 focus-visible:ring-offset-transparent"
            aria-label="Remove"
            {{ $actionAttributes }}
        >
            <x-icons.x class="size-3 shrink-0" />
        </button>
    @endif
</span>
