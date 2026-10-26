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

    $baseClass = 'flex min-h-10 w-full items-center gap-2 rounded-control px-3 py-2.5 text-left text-sm outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface';
@endphp

@if (filled($href) && ! $isDisabled)
    <a
        href="{{ $href }}"
        role="menuitem"
        tabindex="-1"
        {{ $attributes->class([$baseClass, $variantClass]) }}
        x-on:click="hide(true)"
    >
        @if (filled($icon))
            <span class="shrink-0 text-fg-muted [&_svg]:size-4 [&_svg]:shrink-0">{{ $icon }}</span>
        @endif
        <span class="min-w-0 flex-1">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="rounded-control border border-border px-1.5 py-0.5 text-[10px] tabular-nums text-fg-subtle">{{ $shortcut }}</kbd>
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
            x-on:click="hide(true)"
        @endunless
    >
        @if (filled($icon))
            <span class="shrink-0 text-fg-muted [&_svg]:size-4 [&_svg]:shrink-0" @if ($isDisabled) aria-hidden="true" @endif>{{ $icon }}</span>
        @endif
        <span class="min-w-0 flex-1">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="rounded-control border border-border px-1.5 py-0.5 text-[10px] tabular-nums text-fg-subtle">{{ $shortcut }}</kbd>
        @endif
    </button>
@endif
