@props([
    'id' => null,
])

<tr
    {{ $attributes->class(['']) }}
    @if (filled($id))
        x-init="typeof register === 'function' && register(@js($id))"
        x-bind:data-selected="typeof selected !== 'undefined' && selected.includes(@js($id)) ? '' : null"
    @endif
>
    {{ $slot }}
</tr>
