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
    x-on:ui-sidebar-open.window="openMobile()"
>
    <button
        type="button"
        class="mb-3 inline-flex items-center gap-2 rounded-control border border-border px-3 py-2 text-sm text-fg lg:hidden"
        x-on:click="openMobile()"
        x-bind:aria-expanded="open.toString()"
        aria-controls="ui-sidebar-panel"
    >
        <x-icons.menu class="size-4" />
        Menu
    </button>

    <div
        class="fixed inset-0 z-40 bg-fg/40 lg:hidden"
        x-show="open"
        x-cloak
        x-on:click="closeMobile()"
    ></div>

    <nav
        id="ui-sidebar-panel"
        aria-label="{{ $label }}"
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col gap-4 overflow-y-auto border-r border-border bg-surface-raised p-4 shadow-lg transition-[width,transform] lg:static lg:z-0 lg:translate-x-0 lg:shadow-none"
        x-bind:class="{
            'translate-x-0': open,
            '-translate-x-full lg:translate-x-0': !open,
            'lg:w-20': collapsed,
            'lg:w-64': !collapsed
        }"
        x-trap.inert.noscroll="open"
    >
        <div class="hidden items-center justify-between lg:flex">
            <p class="text-sm font-semibold text-fg" x-show="!collapsed">{{ $brand ?? 'Menu' }}</p>
            <button
                type="button"
                class="rounded-control border border-border p-2 text-fg-muted hover:text-fg"
                x-on:click="toggleCollapsed()"
                x-bind:aria-pressed="collapsed.toString()"
                aria-label="Collapse sidebar"
            >
                <x-icons.chevron-right class="size-4 transition-transform" x-bind:class="collapsed ? '' : 'rotate-180'" />
            </button>
        </div>

        <div class="flex items-center justify-between lg:hidden">
            <p class="text-sm font-semibold text-fg">{{ $brand ?? 'Menu' }}</p>
            <button type="button" class="rounded-control p-2 text-fg-muted" x-on:click="closeMobile()" aria-label="Close sidebar">
                <x-icons.x class="size-4" />
            </button>
        </div>

        <div class="flex flex-col gap-4" x-bind:data-collapsed="collapsed ? '' : null">
            {{ $slot }}
        </div>
    </nav>
</aside>
