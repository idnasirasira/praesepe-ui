@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
])

@php
    $solidTactile = 'shadow-[inset_0_1px_0_0_rgba(255,255,255,0.16),0_1px_2px_0_rgba(0,0,0,0.06)] motion-safe:active:translate-y-px';

    $variantClasses = [
        'primary' => 'bg-brand text-on-brand hover:opacity-90 '.$solidTactile,
        'secondary' => 'bg-surface-sunken text-fg hover:bg-border/60 border border-border shadow-2xs motion-safe:active:translate-y-px',
        'outline' => 'bg-transparent text-fg border border-border-strong shadow-2xs hover:bg-surface-sunken motion-safe:active:translate-y-px',
        'ghost' => 'bg-transparent text-fg hover:bg-surface-sunken motion-safe:active:translate-y-px',
        'danger' => 'bg-danger text-on-danger hover:opacity-90 '.$solidTactile,
        'link' => 'bg-transparent text-brand underline-offset-4 hover:underline px-0 h-auto shadow-none motion-safe:active:translate-y-0',
    ];

    $sizeClasses = [
        'sm' => 'h-8 px-2.5 text-xs gap-1.5 rounded-control',
        'md' => 'h-9 px-3.5 text-sm gap-2 rounded-control',
        'lg' => 'h-10 px-4 text-sm gap-2 rounded-control',
        'icon-sm' => 'size-8 p-0 gap-0 rounded-control',
        'icon-md' => 'size-9 p-0 gap-0 rounded-control',
        'icon-lg' => 'size-10 p-0 gap-0 rounded-control',
    ];

    $spinnerClasses = [
        'sm' => 'size-3.5',
        'md' => 'size-4',
        'lg' => 'size-4',
        'icon-sm' => 'size-3.5',
        'icon-md' => 'size-4',
        'icon-lg' => 'size-4',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $spinnerClass = $spinnerClasses[$size] ?? $spinnerClasses['md'];
    $isDisabled = $disabled || $loading;
    $isLink = filled($href);

    $baseClass = 'inline-flex items-center justify-center font-medium transition duration-150 disabled:pointer-events-none disabled:opacity-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface [&_svg]:shrink-0';
@endphp

@if ($isLink)
    <a
        href="{{ $isDisabled ? null : $href }}"
        @if ($isDisabled) aria-disabled="true" tabindex="-1" @endif
        @if ($loading) aria-busy="true" @endif
        {{ $attributes->class([$baseClass, $variantClass, $sizeClass, $isDisabled ? 'pointer-events-none opacity-50' : '']) }}
    >
        @if ($loading)
            <x-icons.spinner class="{{ $spinnerClass }}" />
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @if ($isDisabled) disabled @endif
        @if ($loading) aria-busy="true" @endif
        {{ $attributes->class([$baseClass, $variantClass, $sizeClass]) }}
        @if ($loading) x-bind:disabled="true" @endif
    >
        @if ($loading)
            <x-icons.spinner class="{{ $spinnerClass }}" />
        @endif
        {{ $slot }}
    </button>
@endif
