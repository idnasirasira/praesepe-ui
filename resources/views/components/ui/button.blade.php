@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
])

@php
    $variantClasses = [
        'primary' => 'bg-brand text-on-brand hover:opacity-90 shadow-sm',
        'secondary' => 'bg-surface-sunken text-fg hover:bg-border/60 border border-border',
        'outline' => 'bg-transparent text-fg border border-border-strong hover:bg-surface-sunken',
        'ghost' => 'bg-transparent text-fg hover:bg-surface-sunken',
        'danger' => 'bg-danger text-on-danger hover:opacity-90 shadow-sm',
        'link' => 'bg-transparent text-brand underline-offset-4 hover:underline px-0 h-auto',
    ];

    $sizeClasses = [
        'sm' => 'h-8 px-3 text-xs gap-1.5 rounded-control',
        'md' => 'h-10 px-4 text-sm gap-2 rounded-control',
        'lg' => 'h-11 px-5 text-base gap-2 rounded-control',
        'icon-sm' => 'size-8 p-0 rounded-control',
        'icon-md' => 'size-10 p-0 rounded-control',
        'icon-lg' => 'size-11 p-0 rounded-control',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $isDisabled = $disabled || $loading;
    $isLink = filled($href);

    $baseClass = 'inline-flex items-center justify-center font-medium transition-opacity disabled:pointer-events-none disabled:opacity-50';
@endphp

@if ($isLink)
    <a
        href="{{ $isDisabled ? null : $href }}"
        @if ($isDisabled) aria-disabled="true" tabindex="-1" @endif
        @if ($loading) aria-busy="true" @endif
        {{ $attributes->class([$baseClass, $variantClass, $sizeClass, $isDisabled ? 'pointer-events-none opacity-50' : '']) }}
    >
        @if ($loading)
            <x-icons.spinner class="size-4" />
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
            <x-icons.spinner class="size-4" />
        @endif
        {{ $slot }}
    </button>
@endif
