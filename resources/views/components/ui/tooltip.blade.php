@props([
    'content',
    'position' => 'top',
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-tooltip-'.Str::random(6));
    $tooltipId = $id.'-tip';

    $positionClasses = [
        'top' => 'bottom-full left-1/2 mb-2 -translate-x-1/2',
        'bottom' => 'top-full left-1/2 mt-2 -translate-x-1/2',
        'left' => 'right-full top-1/2 mr-2 -translate-y-1/2',
        'right' => 'left-full top-1/2 ml-2 -translate-y-1/2',
    ];

    $positionClass = $positionClasses[$position] ?? $positionClasses['top'];
@endphp

<span
    {{ $attributes->except(['id'])->class(['relative inline-flex']) }}
    x-data="{ open: false, tooltipId: @js($tooltipId) }"
    x-init="
        const target = $refs.trigger.querySelector('button, a, input, select, textarea, [tabindex]') || $refs.trigger;
        target.setAttribute('aria-describedby', tooltipId);
    "
    x-on:mouseenter="open = true"
    x-on:mouseleave="open = false"
    x-on:focusin="open = true"
    x-on:focusout="open = false"
    x-on:keydown.escape.stop="open = false"
>
    <span x-ref="trigger" class="inline-flex">
        {{ $slot }}
    </span>

    <span
        id="{{ $tooltipId }}"
        role="tooltip"
        x-show="open"
        x-cloak
        x-transition.opacity
        class="pointer-events-none absolute z-50 max-w-xs rounded-control bg-fg px-2 py-1 text-xs text-fg-inverse shadow-md {{ $positionClass }}"
    >
        {{ $content }}
    </span>
</span>
