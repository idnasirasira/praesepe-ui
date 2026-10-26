@props([
    'id',
])

<div
    role="tabpanel"
    id="{{ $id }}-panel"
    aria-labelledby="{{ $id }}-tab"
    x-show="active === @js($id)"
    x-cloak
    x-bind:tabindex="active === @js($id) ? 0 : -1"
    {{ $attributes->class(['pt-2 text-sm text-fg']) }}
>
    {{ $slot }}
</div>
