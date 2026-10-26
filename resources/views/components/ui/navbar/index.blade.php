@props([
    'brandHref' => '/',
])

<header
    {{ $attributes->class(['relative border-b border-border bg-surface-raised']) }}
    x-data="{ open: false }"
    x-on:keydown.escape.window="if (open) open = false"
>
    <div class="mx-auto flex h-14 max-w-7xl items-center gap-4 px-4 sm:px-6">
        <button
            type="button"
            class="inline-flex items-center justify-center rounded-control border border-border p-2 text-fg md:hidden"
            x-on:click="open = true"
            x-bind:aria-expanded="open.toString()"
            aria-controls="ui-navbar-drawer"
            aria-label="Open navigation"
        >
            <x-icons.menu class="size-5" />
        </button>

        <a href="{{ $brandHref }}" class="font-semibold tracking-tight text-fg">
            {{ $brand ?? 'Praesepe App' }}
        </a>

        <nav class="ml-4 hidden items-center gap-1 md:flex" aria-label="Primary">
            {{ $links ?? '' }}
        </nav>

        <div class="ml-auto flex items-center gap-2">
            {{ $actions ?? '' }}
        </div>
    </div>

    <div
        class="fixed inset-0 z-50 md:hidden"
        x-show="open"
        x-cloak
        role="dialog"
        aria-modal="true"
        aria-label="Mobile navigation"
    >
        <div class="absolute inset-0 bg-fg/40" x-on:click="open = false"></div>
        <div
            id="ui-navbar-drawer"
            class="absolute inset-y-0 left-0 flex w-72 flex-col gap-4 border-r border-border bg-surface-raised p-4 shadow-lg"
            x-trap.inert.noscroll="open"
        >
            <div class="flex items-center justify-between">
                <p class="font-semibold text-fg">{{ $brand ?? 'Praesepe App' }}</p>
                <button type="button" class="rounded-control p-2 text-fg-muted" x-on:click="open = false" aria-label="Close navigation">
                    <x-icons.x class="size-4" />
                </button>
            </div>
            <nav class="flex flex-col gap-1" aria-label="Mobile primary">
                {{ $links ?? '' }}
            </nav>
            <div class="mt-auto flex flex-col gap-2 border-t border-border pt-4">
                {{ $actions ?? '' }}
            </div>
        </div>
    </div>
</header>
