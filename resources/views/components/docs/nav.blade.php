@props([
    'groupedComponents' => [],
    'compact' => false,
])

@php
    $linkBase = $compact
        ? 'flex h-10 items-center justify-between gap-2 border-l-2 px-3 text-sm transition-colors duration-150'
        : 'flex items-center justify-between gap-2 border-l-2 px-3 py-2 text-sm transition-colors duration-150';
@endphp

<nav {{ $attributes->class(['space-y-7']) }} aria-label="Documentation">
    @foreach (config('ui-docs.navigation') as $group)
        <div>
            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-fg-subtle">{{ $group['label'] }}</p>
            <ul class="space-y-0.5">
                @foreach ($group['items'] as $item)
                    @php($isActive = request()->routeIs($item['route']))
                    <li>
                        <a
                            href="{{ route($item['route']) }}"
                            @class([
                                $linkBase,
                                'border-brand bg-brand/10 font-medium text-brand' => $isActive,
                                'border-transparent text-fg-muted hover:border-border-strong hover:bg-surface-sunken hover:text-fg' => ! $isActive,
                            ])
                        >
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    @foreach ($groupedComponents as $groupLabel => $components)
        <div>
            <div class="mb-2 flex items-center justify-between gap-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-fg-subtle">{{ $groupLabel }}</p>
                <span class="rounded-pill bg-surface-sunken px-1.5 py-0.5 text-[10px] font-medium tabular-nums text-fg-muted">{{ count($components) }}</span>
            </div>
            <ul class="space-y-0.5">
                @foreach ($components as $component)
                    @php($isActive = request()->routeIs('docs.components.show') && request()->route('slug') === $component->slug)
                    <li>
                        <a
                            href="{{ route('docs.components.show', $component->slug) }}"
                            @class([
                                $linkBase,
                                'border-brand bg-brand/10 font-medium text-brand' => $isActive,
                                'border-transparent text-fg-muted hover:border-border-strong hover:bg-surface-sunken hover:text-fg' => ! $isActive,
                            ])
                        >
                            <span>{{ $component->name }}</span>
                            <span class="rounded-pill bg-surface-sunken px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wide text-fg-subtle">{{ $component->category }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</nav>
