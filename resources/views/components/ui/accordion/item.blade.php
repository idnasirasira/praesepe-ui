@props([
    'id',
    'title',
])

@php
    use Illuminate\Support\Str;

    $itemId = $id ?: 'ui-accordion-'.Str::random(6);
    $headerId = $itemId.'-header';
    $panelId = $itemId.'-panel';
@endphp

<div {{ $attributes->class(['px-4']) }} data-accordion-item="{{ $itemId }}">
    <h3 class="m-0">
        <button
            type="button"
            id="{{ $headerId }}"
            class="flex min-h-11 w-full items-center justify-between gap-3 py-4 text-left text-sm font-medium text-fg outline-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            x-on:click="toggle(@js($itemId))"
            x-bind:aria-expanded="isOpen(@js($itemId)).toString()"
            aria-controls="{{ $panelId }}"
        >
            <span>{{ $title }}</span>
            <x-icons.chevron-down
                class="size-4 shrink-0 text-fg-subtle transition-transform"
                x-bind:class="isOpen(@js($itemId)) ? 'rotate-180' : ''"
            />
        </button>
    </h3>

    <div
        id="{{ $panelId }}"
        role="region"
        aria-labelledby="{{ $headerId }}"
        x-bind:aria-hidden="(!isOpen(@js($itemId))).toString()"
        class="grid transition-[grid-template-rows] duration-200 ease-out motion-reduce:transition-none"
        x-bind:class="isOpen(@js($itemId)) ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'"
    >
        <div class="overflow-hidden">
            <div
                class="pb-4 text-sm text-fg-muted transition-opacity duration-200 motion-reduce:transition-none"
                x-bind:class="isOpen(@js($itemId)) ? 'opacity-100' : 'opacity-0'"
            >
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
