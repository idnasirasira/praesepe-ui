@props([
    'variant' => 'default',
    'href' => null,
])

@php
    $variantClasses = [
        'default' => 'border border-border bg-surface-raised shadow-sm',
        'sunken' => 'border border-transparent bg-surface-sunken',
        'interactive' => 'border border-border bg-surface-raised shadow-sm transition-colors hover:border-border-strong hover:bg-surface',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['default'];
    $isInteractive = $variant === 'interactive' || filled($href);
@endphp

<div
    {{ $attributes->class([
        'relative overflow-hidden rounded-card',
        $variantClass,
        $isInteractive ? 'focus-within:outline focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-[var(--ui-ring)]' : '',
    ]) }}
>
    @isset($media)
        <div class="border-b border-border">
            {{ $media }}
        </div>
    @endisset

    @isset($header)
        <div class="border-b border-border px-4 py-3">
            {{ $header }}
        </div>
    @endisset

    <div class="px-4 py-4">
        @if ($isInteractive && filled($href))
            <a
                href="{{ $href }}"
                class="font-medium text-fg after:absolute after:inset-0 after:z-0 after:content-[''] focus:outline-none"
            >
                <span class="relative z-10">{{ $title ?? $slot }}</span>
            </a>
            @isset($title)
                <div class="relative z-10 mt-2 text-sm text-fg-muted">
                    {{ $slot }}
                </div>
            @endisset
        @else
            {{ $slot }}
        @endif
    </div>

    @isset($footer)
        <div class="relative z-10 border-t border-border px-4 py-3">
            {{ $footer }}
        </div>
    @endisset
</div>
