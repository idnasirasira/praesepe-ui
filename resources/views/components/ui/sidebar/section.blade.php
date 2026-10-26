@props([
    'title' => null,
])

<div {{ $attributes->class(['space-y-1']) }}>
    @if (filled($title))
        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-fg-subtle" x-show="!collapsed || open">
            {{ $title }}
        </p>
    @endif
    <div class="flex flex-col gap-1">
        {{ $slot }}
    </div>
</div>
