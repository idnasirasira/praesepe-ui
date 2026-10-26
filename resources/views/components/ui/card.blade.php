@props([
    'variant' => 'default',
    'href' => null,
])

@php
    $variantClasses = [
        'default' => 'border border-border bg-surface-raised shadow-sm ring-1 ring-border/60',
        'sunken' => 'border border-transparent bg-surface-sunken',
        'interactive' => 'border border-border bg-surface-raised shadow-sm ring-1 ring-border/60 transition-colors duration-150 hover:border-border-strong hover:bg-surface-raised hover:shadow-md',
    ];

    $variantClass = $variantClasses[$variant] ?? $variantClasses['default'];
    $isInteractive = $variant === 'interactive' || filled($href);
@endphp

<div
    {{ $attributes->class([
        'relative overflow-hidden rounded-card',
        $variantClass,
        $isInteractive ? 'focus-within:outline-none focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2 focus-within:ring-offset-surface' : '',
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
                <div class="relative z-10 mt-2 text-sm text-fg-muted leading-relaxed">
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
