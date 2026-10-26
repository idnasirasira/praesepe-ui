@props([
    'href' => null,
    'current' => false,
])

<li class="inline-flex items-center gap-1.5">
    @if ($current || blank($href))
        <span class="font-medium text-fg" @if ($current) aria-current="page" @endif>
            {{ $slot }}
        </span>
    @else
        <a
            href="{{ $href }}"
            {{ $attributes->class([
                'rounded-control text-fg-muted transition-colors duration-150 hover:text-fg',
                'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
            ]) }}
        >
            {{ $slot }}
        </a>
        <span class="text-fg-subtle" aria-hidden="true">
            <x-icons.chevron-right class="size-3.5 shrink-0" />
        </span>
    @endif
</li>
