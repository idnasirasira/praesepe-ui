@props([
    'showText' => true,
])

{{-- Studio / company lockup for praesepe.id. Use x-docs.logo for ui.praesepe.id. --}}
<span {{ $attributes->class(['inline-flex items-center gap-2 select-none']) }}>
    <span class="inline-flex size-7 shrink-0 items-center justify-center rounded-control border border-border bg-surface-raised text-fg shadow-2xs">
        <x-icons.praesepe class="size-4 shrink-0" />
    </span>

    @if ($showText)
        <span class="text-base font-semibold tracking-tight text-fg">Praesepe</span>
    @endif
</span>
