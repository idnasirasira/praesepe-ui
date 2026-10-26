@props([
    'homeHref' => null,
    'homeLabel' => 'Home',
])

<nav {{ $attributes->class(['text-sm']) }} aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 text-fg-muted">
        @if (filled($homeHref))
            <li class="inline-flex items-center gap-1.5">
                <a href="{{ $homeHref }}" class="inline-flex items-center gap-1 rounded-control text-fg-muted hover:text-fg">
                    <x-icons.home class="size-4" />
                    <span class="sr-only">{{ $homeLabel }}</span>
                </a>
                <span class="text-fg-subtle" aria-hidden="true">
                    <x-icons.chevron-right class="size-3.5" />
                </span>
            </li>
        @endif

        {{ $slot }}
    </ol>
</nav>
