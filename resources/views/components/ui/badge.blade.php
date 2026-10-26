@props([
    'variant' => 'soft',
    'color' => 'neutral',
    'size' => 'md',
    'dot' => false,
    'removable' => false,
    'dismissible' => false,
    'dismissLabel' => 'Remove',
])

@php
    $isRemovable = $removable || $dismissible;

    $toneClasses = [
        'solid-neutral' => 'bg-fg text-fg-inverse',
        'solid-brand' => 'bg-brand text-on-brand',
        'solid-success' => 'bg-success text-on-success',
        'solid-warning' => 'bg-warning text-on-warning',
        'solid-danger' => 'bg-danger text-on-danger',
        'solid-info' => 'bg-info text-on-info',
        'soft-neutral' => 'bg-surface-sunken text-fg ring-1 ring-inset ring-current/15',
        'soft-brand' => 'bg-brand/10 text-brand ring-1 ring-inset ring-current/15',
        'soft-success' => 'bg-success-soft text-success ring-1 ring-inset ring-current/15',
        'soft-warning' => 'bg-warning-soft text-warning ring-1 ring-inset ring-current/15',
        'soft-danger' => 'bg-danger-soft text-danger ring-1 ring-inset ring-current/15',
        'soft-info' => 'bg-info-soft text-info ring-1 ring-inset ring-current/15',
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
        'sm' => 'gap-1 px-1.5 py-0.5 text-[11px]',
        'md' => 'gap-1.5 px-2 py-0.5 text-xs',
    ];

    $iconSizeClasses = [
        'sm' => 'size-3',
        'md' => 'size-3.5',
    ];

    $toneKey = $variant.'-'.$color;
    $toneClass = $toneClasses[$toneKey] ?? $toneClasses['soft-neutral'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $iconSizeClass = $iconSizeClasses[$size] ?? $iconSizeClasses['md'];
    $dotClass = $dotClasses[$color] ?? $dotClasses['neutral'];
    $actionAttributes = $attributes->whereStartsWith(['x-on:', 'wire:']);
    $wrapperAttributes = $attributes->whereDoesntStartWith(['x-on:', 'wire:']);
@endphp

<span
    {{ $wrapperAttributes->class([
        'inline-flex items-center rounded-pill font-medium tabular-nums shadow-2xs',
        $toneClass,
        $sizeClass,
    ]) }}
>
    @if ($dot)
        <span class="size-1.5 shrink-0 rounded-full {{ $dotClass }}" aria-hidden="true"></span>
    @endif

    @isset($icon)
        <span class="{{ $iconSizeClass }} shrink-0 [&_svg]:size-full" aria-hidden="true">{{ $icon }}</span>
    @endisset

    <span>{{ $slot }}</span>

    @if ($isRemovable)
        <button
            type="button"
            class="relative -mr-0.5 ml-0.5 inline-flex size-4 shrink-0 items-center justify-center rounded-pill opacity-80 transition-colors hover:bg-black/10 hover:opacity-100 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring dark:hover:bg-white/15 after:absolute after:-inset-2 after:content-['']"
            aria-label="{{ $dismissLabel }}"
            {{ $actionAttributes }}
        >
            <x-icons.x class="size-3 shrink-0" />
        </button>
    @endif
</span>
