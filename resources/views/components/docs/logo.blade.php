@props([
    'showText' => true,
    'showBadge' => true,
])

{{-- Product lockup for ui.praesepe.id. Use x-docs.praesepe-logo for praesepe.id. --}}
<span {{ $attributes->class(['inline-flex items-center gap-2.5 select-none']) }}>
    {{-- Modular P Grid Mark --}}
    <span class="inline-flex size-7 shrink-0 items-center justify-center rounded-control bg-brand text-on-brand shadow-2xs ring-1 ring-inset ring-white/15">
        <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none">
            {{-- Top-left primary block --}}
            <rect x="4" y="4" width="7" height="7" rx="1.75" fill="currentColor" />
            {{-- Top-right loop of P --}}
            <rect x="13" y="4" width="7" height="7" rx="3.5" fill="currentColor" fill-opacity="0.85" />
            {{-- Bottom-left stem of P --}}
            <rect x="4" y="13" width="7" height="7" rx="1.75" fill="currentColor" />
            {{-- Bottom-right subtle accent dot --}}
            <circle cx="16.5" cy="16.5" r="2.25" fill="currentColor" fill-opacity="0.4" />
        </svg>
    </span>

    @if ($showText)
        <span class="inline-flex items-center gap-1.5">
            <span class="text-base font-semibold tracking-tight text-fg">Praesepe</span>
            @if ($showBadge)
                <span class="rounded-[5px] border border-border bg-surface-sunken px-1.5 py-0.5 font-mono text-[11px] font-medium leading-none text-fg-muted">
                    UI
                </span>
            @endif
        </span>
    @endif
</span>
