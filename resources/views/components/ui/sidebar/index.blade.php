@props([
    'collapsed' => false,
    'label' => 'Sidebar',
])

<aside
    {{ $attributes->class(['relative']) }}
    x-data="{
        open: false,
        collapsed: @js((bool) $collapsed),
        toggleCollapsed() { this.collapsed = !this.collapsed },
        openMobile() { this.open = true },
        closeMobile() { this.open = false },
    }"
    x-on:keydown.escape.window="if (open) closeMobile()"
    x-on:resize.window="if (window.innerWidth >= 1024 && open) closeMobile()"
    x-on:ui-sidebar-open.window="openMobile()"
>
    <button
        type="button"
        class="mb-3 inline-flex h-10 items-center gap-2 rounded-control border border-border bg-surface-raised px-3 text-sm text-fg shadow-2xs lg:hidden"
        x-on:click="openMobile()"
        x-bind:aria-expanded="open.toString()"
        aria-controls="ui-sidebar-panel"
        aria-label="Open sidebar menu"
    >
        <x-icons.menu class="size-4 shrink-0" />
        Menu
    </button>

    {{-- Desktop static sidebar --}}
    <nav
        aria-label="{{ $label }}"
        class="hidden h-full flex-col gap-4 overflow-y-auto border-r border-border bg-surface-raised p-4 transition-[width] lg:flex"
        x-bind:class="collapsed ? 'lg:w-20' : 'lg:w-64'"
        x-bind:data-collapsed="collapsed ? '' : null"
    >
        <div class="flex items-center justify-between">
            <p class="text-sm font-semibold tracking-tight text-fg" x-show="!collapsed">{{ $brand ?? 'Menu' }}</p>
            <p class="text-sm font-semibold tracking-tight text-fg" x-show="collapsed" x-cloak>{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr((string) ($brand ?? 'M'), 0, 1)) }}</p>
            <button
                type="button"
                class="inline-flex size-9 items-center justify-center rounded-control border border-border text-fg-muted transition-colors duration-150 hover:bg-surface-sunken hover:text-fg"
                x-on:click="toggleCollapsed()"
                x-bind:aria-pressed="collapsed.toString()"
                aria-label="Collapse sidebar"
            >
                <x-icons.chevron-right class="size-4 shrink-0 transition-transform" x-bind:class="collapsed ? '' : 'rotate-180'" />
            </button>
        </div>

        <div class="flex flex-col gap-4">
            {{ $slot }}
        </div>
    </nav>

    {{-- Teleported mobile drawer --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            role="dialog"
            aria-modal="true"
            aria-label="{{ $label }}"
            class="fixed inset-0 z-50 lg:hidden"
        >
            <div
                x-show="open"
                x-transition:enter="transition-opacity ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click="closeMobile()"
                aria-hidden="true"
                class="fixed inset-0 bg-overlay backdrop-blur-[2px]"
            ></div>

            <nav
                id="ui-sidebar-panel"
                aria-label="{{ $label }}"
                x-show="open"
                x-trap.inert.noscroll="open"
                x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-150 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative flex h-full w-[min(20rem,calc(100vw-2.5rem))] flex-col gap-4 overflow-y-auto overscroll-contain border-r border-border bg-surface-raised p-4 shadow-xl"
            >
                <div class="flex h-10 items-center justify-between">
                    <p class="text-sm font-semibold tracking-tight text-fg">{{ $brand ?? 'Menu' }}</p>
                    <button
                        type="button"
                        class="inline-flex size-9 items-center justify-center rounded-control text-fg-muted transition-colors duration-150 hover:bg-surface-sunken hover:text-fg"
                        x-on:click="closeMobile()"
                        aria-label="Close sidebar"
                    >
                        <x-icons.x class="size-4 shrink-0" />
                    </button>
                </div>

                <div class="flex flex-col gap-4">
                    {{ $slot }}
                </div>
            </nav>
        </div>
    </template>
</aside>
