@props([
    'href' => '#',
    'current' => false,
])

<a
    href="{{ $href }}"
    @if ($current) aria-current="page" @endif
    {{ $attributes->class([
        'inline-flex h-10 items-center rounded-control px-3 text-sm font-medium transition-colors duration-150',
        'border-l-2 border-brand bg-brand/10 font-medium text-brand md:border-l-0 md:bg-surface-sunken md:text-fg' => $current,
        'border-l-2 border-transparent text-fg-muted hover:border-border-strong hover:bg-surface-sunken hover:text-fg md:border-l-0' => ! $current,
    ]) }}
>
    {{ $slot }}
</a>
