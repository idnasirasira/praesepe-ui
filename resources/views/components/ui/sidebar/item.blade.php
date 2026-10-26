@props([
    'href' => '#',
    'current' => false,
    'label' => null,
])

@php
    $title = $label ?? trim(strip_tags($slot->toHtml()));
@endphp

<a
    href="{{ $href }}"
    @if ($current) aria-current="page" @endif
    {{ $attributes->class([
        'inline-flex h-10 items-center gap-3 rounded-control px-3 text-sm font-medium transition-colors duration-150',
        'bg-brand/10 font-medium text-brand lg:bg-surface-sunken lg:text-fg' => $current,
        'text-fg-muted hover:bg-surface-sunken hover:text-fg' => ! $current,
    ]) }}
    x-bind:title="collapsed && !open ? @js($title) : null"
>
    @isset($icon)
        <span class="shrink-0 text-fg-muted" aria-hidden="true">{{ $icon }}</span>
    @endisset
    <span class="truncate" x-show="!collapsed || open">{{ $slot }}</span>
</a>
