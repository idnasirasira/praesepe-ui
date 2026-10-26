@props([
    'href' => '#',
    'current' => false,
])

<a
    href="{{ $href }}"
    @if ($current) aria-current="page" @endif
    {{ $attributes->class([
        'rounded-control px-3 py-2 text-sm font-medium',
        'bg-surface-sunken text-fg' => $current,
        'text-fg-muted hover:bg-surface-sunken hover:text-fg' => ! $current,
    ]) }}
>
    {{ $slot }}
</a>
