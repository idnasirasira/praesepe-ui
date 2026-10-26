@props([
    'brandHref' => '/',
    'brandName' => 'Praesepe UI',
    'sticky' => true,
    'mobileStyle' => 'drawer',
])

@php
    $resolvedBrand = isset($brand) ? trim((string) $brand) : $brandName;
    $isFloating = $mobileStyle === 'floating';

    $headerClasses = [
        'w-full border-b border-border bg-surface/85 backdrop-blur-md transition-colors duration-150',
        $sticky ? 'sticky top-0 z-40' : 'relative z-40',
    ];
@endphp

<header
    x-data="{
        mobileOpen: false,
        close() {
            this.mobileOpen = false;
        }
    }"
    x-on:keydown.escape.window="if (mobileOpen) close()"
    x-on:resize.window="if (window.innerWidth >= 768 && mobileOpen) close()"
    {{ $attributes->class($headerClasses) }}
>
    <div class="mx-auto flex h-14 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex min-w-0 items-center gap-6">
            <a
                href="{{ $brandHref }}"
                class="inline-flex items-center gap-2.5 rounded-control text-base font-semibold tracking-tight text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            >
                @isset($logo)
                    {{ $logo }}
                @else
                    <span class="inline-flex size-7 shrink-0 items-center justify-center rounded-control bg-brand text-xs font-bold text-on-brand shadow-2xs" aria-hidden="true">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($resolvedBrand !== '' ? $resolvedBrand : 'P', 0, 1)) }}
                    </span>
                @endisset
                @if ($resolvedBrand !== '')
                    <span class="truncate">{{ $resolvedBrand }}</span>
                @endif
            </a>

            @isset($links)
                <nav aria-label="Main navigation" class="hidden md:flex md:items-center md:gap-1">
                    {{ $links }}
                </nav>
            @endisset
        </div>

        <div class="flex shrink-0 items-center gap-2">
            @isset($mobileBarActions)
                <div class="flex items-center gap-1.5 md:hidden">
                    {{ $mobileBarActions }}
                </div>
            @endisset

            @isset($actions)
                <div class="hidden md:flex md:items-center md:gap-2">
                    {{ $actions }}
                </div>
            @endisset

            <button
                type="button"
                class="inline-flex size-10 items-center justify-center rounded-control border border-border bg-surface-raised text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface md:hidden"
                x-on:click="mobileOpen = !mobileOpen"
                x-bind:aria-expanded="mobileOpen.toString()"
                aria-controls="ui-navbar-drawer"
                aria-label="Open navigation menu"
            >
                <svg
                    x-show="!mobileOpen"
                    aria-hidden="true"
                    class="size-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.75"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M4 7h16" />
                    <path d="M4 12h16" />
                    <path d="M4 17h12" />
                </svg>
                <svg
                    x-show="mobileOpen"
                    x-cloak
                    aria-hidden="true"
                    class="size-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.75"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
    </div>

    @if ($isFloating)
        <div
            x-show="mobileOpen"
            x-cloak
            id="ui-navbar-drawer"
            role="dialog"
            aria-modal="true"
            aria-label="Mobile navigation"
            class="absolute inset-x-3 top-[calc(100%+0.5rem)] z-50 md:hidden"
            x-trap.inert.noscroll="mobileOpen"
        >
            <div
                class="overflow-hidden rounded-card border border-border bg-surface-raised shadow-xl ring-1 ring-border/60"
                x-show="mobileOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                x-on:click.outside="close()"
            >
                <div class="max-h-[min(24rem,70dvh)] overflow-y-auto overscroll-contain px-3 py-3">
                    @isset($mobileLinks)
                        <nav aria-label="Mobile navigation links" class="flex flex-col gap-1">
                            {{ $mobileLinks }}
                        </nav>
                    @elseif (isset($links))
                        <nav aria-label="Mobile navigation links" class="flex flex-col gap-1">
                            {{ $links }}
                        </nav>
                    @endisset
                </div>

                @if (isset($mobileFooter) || isset($actions))
                    <div class="border-t border-border bg-surface p-3">
                        {{ $mobileFooter ?? $actions }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <template x-teleport="body">
            <div
                x-show="mobileOpen"
                x-cloak
                id="ui-navbar-drawer"
                role="dialog"
                aria-modal="true"
                aria-label="Mobile navigation"
                class="fixed inset-0 z-50 md:hidden"
            >
                <div
                    x-show="mobileOpen"
                    x-cloak
                    x-transition:enter="transition-opacity ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-on:click="close()"
                    aria-hidden="true"
                    class="fixed inset-0 bg-overlay backdrop-blur-[2px]"
                ></div>

                <div
                    x-show="mobileOpen"
                    x-cloak
                    x-trap.inert.noscroll="mobileOpen"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-100 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative flex h-full w-[min(20rem,calc(100vw-2.5rem))] flex-col justify-between border-r border-border bg-surface-raised shadow-xl"
                >
                    <div class="flex h-14 shrink-0 items-center justify-between border-b border-border px-4">
                        @isset($logo)
                            {{ $logo }}
                        @else
                            <span class="text-sm font-semibold tracking-tight text-fg">{{ $resolvedBrand }}</span>
                        @endisset
                        <button
                            type="button"
                            x-on:click="close()"
                            class="inline-flex size-10 items-center justify-center rounded-control text-fg-muted transition-colors duration-150 hover:bg-surface-sunken hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                            aria-label="Close navigation menu"
                        >
                            <x-icons.x class="size-4 shrink-0" />
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto overscroll-contain px-3 py-4">
                        @isset($mobileLinks)
                            <nav aria-label="Mobile navigation links" class="flex flex-col gap-1">
                                {{ $mobileLinks }}
                            </nav>
                        @elseif (isset($links))
                            <nav aria-label="Mobile navigation links" class="flex flex-col gap-1">
                                {{ $links }}
                            </nav>
                        @endisset
                    </div>

                    @if (isset($mobileFooter) || isset($actions))
                        <div class="shrink-0 border-t border-border bg-surface p-4">
                            {{ $mobileFooter ?? $actions }}
                        </div>
                    @endif
                </div>
            </div>
        </template>
    @endif
</header>
