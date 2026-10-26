@props([
    'href' => null,
    'current' => false,
])

<li class="inline-flex max-w-[12rem] shrink-0 items-center gap-1.5 sm:max-w-none">
    @if ($current || blank($href))
        <span class="truncate font-medium text-fg" @if ($current) aria-current="page" @endif>
            {{ $slot }}
        </span>
    @else
        <a
            href="{{ $href }}"
            {{ $attributes->class([
                'truncate rounded-control text-fg-muted transition-colors duration-150 hover:text-fg',
                'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
            ]) }}
        >
            {{ $slot }}
        </a>
        <span class="shrink-0 text-fg-subtle" aria-hidden="true">
            <x-icons.chevron-right class="size-3.5 shrink-0" />
        </span>
    @endif
</li>
