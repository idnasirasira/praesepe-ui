@props([
    'max' => null,
])

<div {{ $attributes->class(['flex items-center -space-x-2']) }}>
    {{ $slot }}

    @isset($overflow)
        <span class="relative z-10 inline-flex size-10 items-center justify-center rounded-full bg-surface-sunken text-xs font-medium text-fg ring-2 ring-surface">
            {{ $overflow }}
        </span>
    @endisset
</div>
