@props([
    'variant' => 'numbered',
    'current' => 1,
    'total' => 1,
    'perPage' => 10,
    'totalItems' => null,
])

@php
    $current = max(1, (int) $current);
    $total = max(1, (int) $total);
    $perPage = max(1, (int) $perPage);
    $totalItems = $totalItems !== null ? (int) $totalItems : $total * $perPage;
    $from = min(($current - 1) * $perPage + 1, $totalItems);
    $to = min($current * $perPage, $totalItems);

    $pages = [];
    if ($total <= 7) {
        $pages = range(1, $total);
    } else {
        $pages[] = 1;
        $start = max(2, $current - 1);
        $end = min($total - 1, $current + 1);
        if ($start > 2) {
            $pages[] = 'ellipsis-start';
        }
        foreach (range($start, $end) as $page) {
            $pages[] = $page;
        }
        if ($end < $total - 1) {
            $pages[] = 'ellipsis-end';
        }
        $pages[] = $total;
    }
@endphp

<nav {{ $attributes->class(['flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between']) }} aria-label="Pagination">
    <p class="text-sm text-fg-muted">
        Showing <span class="font-medium text-fg">{{ $from }}</span>
        to <span class="font-medium text-fg">{{ $to }}</span>
        of <span class="font-medium text-fg">{{ $totalItems }}</span> results
    </p>

    @if ($variant === 'simple')
        <div class="flex items-center gap-2">
            <a
                href="?page={{ max(1, $current - 1) }}"
                @class([
                    'inline-flex h-9 items-center rounded-control border border-border px-3 text-sm',
                    'pointer-events-none opacity-50' => $current <= 1,
                    'text-fg hover:bg-surface-sunken' => $current > 1,
                ])
                @if ($current <= 1) aria-disabled="true" tabindex="-1" @endif
            >
                Previous
            </a>
            <a
                href="?page={{ min($total, $current + 1) }}"
                @class([
                    'inline-flex h-9 items-center rounded-control border border-border px-3 text-sm',
                    'pointer-events-none opacity-50' => $current >= $total,
                    'text-fg hover:bg-surface-sunken' => $current < $total,
                ])
                @if ($current >= $total) aria-disabled="true" tabindex="-1" @endif
            >
                Next
            </a>
        </div>
    @else
        <ul class="flex flex-wrap items-center gap-1">
            <li>
                <a
                    href="?page={{ max(1, $current - 1) }}"
                    class="inline-flex size-9 items-center justify-center rounded-control border border-border text-sm {{ $current <= 1 ? 'pointer-events-none opacity-50' : 'text-fg hover:bg-surface-sunken' }}"
                    aria-label="Previous page"
                    @if ($current <= 1) aria-disabled="true" tabindex="-1" @endif
                >
                    ‹
                </a>
            </li>
            @foreach ($pages as $page)
                <li>
                    @if (is_string($page))
                        <span class="inline-flex size-9 items-center justify-center text-sm text-fg-subtle" aria-hidden="true">…</span>
                    @else
                        <a
                            href="?page={{ $page }}"
                            @class([
                                'inline-flex size-9 items-center justify-center rounded-control text-sm',
                                'bg-brand text-on-brand' => $page === $current,
                                'border border-border text-fg hover:bg-surface-sunken' => $page !== $current,
                            ])
                            @if ($page === $current) aria-current="page" @endif
                        >
                            {{ $page }}
                        </a>
                    @endif
                </li>
            @endforeach
            <li>
                <a
                    href="?page={{ min($total, $current + 1) }}"
                    class="inline-flex size-9 items-center justify-center rounded-control border border-border text-sm {{ $current >= $total ? 'pointer-events-none opacity-50' : 'text-fg hover:bg-surface-sunken' }}"
                    aria-label="Next page"
                    @if ($current >= $total) aria-disabled="true" tabindex="-1" @endif
                >
                    ›
                </a>
            </li>
        </ul>
    @endif
</nav>
