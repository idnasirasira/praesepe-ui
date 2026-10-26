@props([
    'variant' => 'default',
    'href' => null,
    'disabled' => false,
    'shortcut' => null,
    'icon' => null,
])

@php
    $variantClasses = [
        'default' => 'text-fg hover:bg-surface-sunken focus:bg-surface-sunken',
        'danger' => 'text-danger hover:bg-danger-soft focus:bg-danger-soft',
        'disabled' => 'text-fg-subtle cursor-not-allowed opacity-60',
    ];

    $isDisabled = $disabled || $variant === 'disabled';
    $variantClass = $isDisabled
        ? $variantClasses['disabled']
        : ($variantClasses[$variant] ?? $variantClasses['default']);

    $baseClass = 'flex w-full items-center gap-2 rounded-control px-3 py-2 text-left text-sm outline-none';
@endphp

@if (filled($href) && ! $isDisabled)
    <a
        href="{{ $href }}"
        role="menuitem"
        tabindex="-1"
        {{ $attributes->class([$baseClass, $variantClass]) }}
        x-on:click="hide(false)"
    >
        @if (filled($icon))
            <span class="shrink-0 text-fg-muted">{{ $icon }}</span>
        @endif
        <span class="min-w-0 flex-1">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="rounded border border-border px-1.5 py-0.5 text-[10px] text-fg-subtle">{{ $shortcut }}</kbd>
        @endif
    </a>
@else
    <button
        type="button"
        role="menuitem"
        tabindex="-1"
        @if ($isDisabled) disabled aria-disabled="true" @endif
        {{ $attributes->class([$baseClass, $variantClass]) }}
        @unless ($isDisabled)
            x-on:click="hide(false)"
        @endunless
    >
        @if (filled($icon))
            <span class="shrink-0 text-fg-muted" @if ($isDisabled) aria-hidden="true" @endif>{{ $icon }}</span>
        @endif
        <span class="min-w-0 flex-1">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="rounded border border-border px-1.5 py-0.5 text-[10px] text-fg-subtle">{{ $shortcut }}</kbd>
        @endif
    </button>
@endif
