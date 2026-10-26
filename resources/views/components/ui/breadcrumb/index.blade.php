@props([
    'homeHref' => null,
    'homeLabel' => 'Home',
])

<nav {{ $attributes->class(['text-sm']) }} aria-label="Breadcrumb">
    <ol class="flex items-center gap-1.5 overflow-x-auto whitespace-nowrap py-1 text-fg-muted">
        @if (filled($homeHref))
            <li class="inline-flex shrink-0 items-center gap-1.5">
                <a
                    href="{{ $homeHref }}"
                    class="inline-flex items-center gap-1 rounded-control text-fg-muted transition-colors duration-150 hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                >
                    <x-icons.home class="size-4 shrink-0" />
                    <span class="sr-only">{{ $homeLabel }}</span>
                </a>
                <span class="text-fg-subtle" aria-hidden="true">
                    <x-icons.chevron-right class="size-3.5 shrink-0" />
                </span>
            </li>
        @endif

        {{ $slot }}
    </ol>
</nav>
