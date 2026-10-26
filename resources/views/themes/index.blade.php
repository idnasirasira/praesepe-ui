@extends('layouts.docs')

@section('title', 'Themes · '.config('ui-docs.name'))
@section('meta_description', 'Preview praesepe, minimal, and warm themes, then build your own brand theme with live OKLCH controls.')

@section('toc')
    <x-docs.toc :items="[
        ['id' => 'built-in', 'label' => 'Built-in themes'],
        ['id' => 'custom-palette', 'label' => 'Build your own'],
        ['id' => 'token-samples', 'label' => 'Token samples'],
    ]" />
@endsection

@section('content')
<div class="mx-auto max-w-4xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg text-balance">Themes</h1>
    <p class="mt-3 max-w-3xl text-fg-muted leading-relaxed text-pretty">
        Pick a built-in theme, or build your own brand palette and save it as
        <strong class="font-medium text-fg">My theme</strong> in the header switcher.
    </p>

    <p class="mt-4">
        <a
            href="#custom-palette"
            class="inline-flex h-9 items-center rounded-control border border-border bg-surface-raised px-3.5 text-sm font-medium text-fg shadow-2xs transition-colors duration-150 hover:border-border-strong focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
        >
            Build your own theme
        </a>
    </p>

    <h2 id="built-in" class="mt-10 text-xl font-semibold tracking-tight text-fg">Built-in themes</h2>
    <div class="mt-4 grid gap-4 md:grid-cols-3">
        @foreach ($themes as $theme)
            <button
                type="button"
                class="rounded-card border border-border bg-surface-raised p-5 text-left shadow-2xs transition-colors duration-150 hover:border-border-strong focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                x-data
                x-on:click="window.PraesepeTheme?.setTheme(@js($theme['id']))"
            >
                <div class="flex h-16 items-end gap-2 rounded-control bg-surface-sunken p-3">
                    <span class="size-6 rounded-full bg-brand"></span>
                    <span class="size-6 rounded-full bg-success"></span>
                    <span class="size-6 rounded-full bg-warning"></span>
                    <span class="size-6 rounded-full bg-danger"></span>
                    <span class="size-6 rounded-full bg-info"></span>
                </div>
                <h3 class="mt-4 text-base font-semibold tracking-tight text-fg">{{ $theme['name'] }}</h3>
                <p class="mt-1 text-sm text-fg-muted leading-relaxed">{{ $theme['description'] }}</p>
            </button>
        @endforeach
    </div>

    <section
        id="custom-palette"
        class="mt-12 space-y-6 scroll-mt-24"
        x-data="paletteLab()"
    >
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-fg">Build your own theme</h2>
            <p class="mt-2 max-w-3xl text-sm text-fg-muted leading-relaxed text-pretty">
                Mix brand hue, chroma, and lightness in OKLCH. Preview updates live.
                Click <strong class="font-medium text-fg">Use as my theme</strong> to save it into the header theme switcher.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <template x-for="preset in presets" x-bind:key="preset.id">
                <button
                    type="button"
                    class="inline-flex h-8 items-center gap-2 rounded-pill border border-border bg-surface-raised px-3 text-xs font-medium text-fg shadow-2xs transition-colors duration-150 hover:border-border-strong focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    x-on:click="applyPreset(preset)"
                >
                    <span
                        class="size-3.5 shrink-0 rounded-full border border-border"
                        x-bind:style="`background: oklch(${preset.lightness} ${preset.chroma} ${preset.hue})`"
                    ></span>
                    <span x-text="preset.label"></span>
                </button>
            </template>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,18rem)_minmax(0,1fr)]">
            <div class="space-y-5 rounded-card border border-border bg-surface-raised p-5 shadow-2xs">
                <label class="block space-y-2">
                    <span class="text-xs font-medium text-fg">Theme name</span>
                    <input
                        type="text"
                        maxlength="40"
                        class="h-9 w-full rounded-control border border-border bg-surface px-3 text-sm text-fg shadow-2xs tabular-nums transition-colors duration-150 hover:border-border-strong focus:border-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        x-model="name"
                        x-on:input="onChange()"
                        placeholder="My theme"
                    >
                </label>

                <div class="space-y-2">
                    <span class="text-xs font-medium text-fg">Brand hex</span>
                    <div class="flex items-center gap-2">
                        <input
                            type="color"
                            class="size-9 shrink-0 cursor-pointer rounded-control border border-border bg-surface p-1 shadow-2xs transition-colors duration-150 hover:border-border-strong focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                            x-bind:value="hex"
                            x-on:input="onHexPicker($event)"
                            aria-label="Pick brand hex color"
                        >
                        <input
                            type="text"
                            spellcheck="false"
                            autocomplete="off"
                            maxlength="7"
                            placeholder="#4f46e5"
                            class="h-9 min-w-0 flex-1 rounded-control border border-border bg-surface px-3 font-mono text-sm text-fg shadow-2xs tabular-nums transition-colors duration-150 hover:border-border-strong focus:border-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                            x-bind:class="hexError && 'border-danger focus:border-danger focus-visible:ring-danger'"
                            x-model="hex"
                            x-on:change="onHexInput()"
                            x-on:keydown.enter.prevent="onHexInput()"
                        >
                    </div>
                    <p class="text-xs text-fg-muted leading-relaxed">
                        Paste a hex value. We convert it to OKLCH for the brand token and sliders below.
                    </p>
                    <p
                        class="text-xs text-danger"
                        x-show="hexError"
                        x-cloak
                    >
                        Use a valid hex like <span class="font-mono">#4f46e5</span> or <span class="font-mono">#46e</span>.
                    </p>
                </div>

                <label class="block space-y-2">
                    <span class="flex items-center justify-between text-xs font-medium text-fg">
                        <span>Hue</span>
                        <span class="tabular-nums text-fg-muted" x-text="Math.round(hue)"></span>
                    </span>
                    <input
                        type="range"
                        min="0"
                        max="360"
                        step="1"
                        class="w-full accent-brand"
                        x-model.number="hue"
                        x-on:input="onChange()"
                    >
                </label>

                <label class="block space-y-2">
                    <span class="flex items-center justify-between text-xs font-medium text-fg">
                        <span>Chroma</span>
                        <span class="tabular-nums text-fg-muted" x-text="Number(chroma).toFixed(2)"></span>
                    </span>
                    <input
                        type="range"
                        min="0.02"
                        max="0.22"
                        step="0.01"
                        class="w-full accent-brand"
                        x-model.number="chroma"
                        x-on:input="onChange()"
                    >
                </label>

                <label class="block space-y-2">
                    <span class="flex items-center justify-between text-xs font-medium text-fg">
                        <span>Lightness</span>
                        <span class="tabular-nums text-fg-muted" x-text="Number(lightness).toFixed(2)"></span>
                    </span>
                    <input
                        type="range"
                        min="0.28"
                        max="0.72"
                        step="0.01"
                        class="w-full accent-brand"
                        x-model.number="lightness"
                        x-on:input="onChange()"
                    >
                </label>

                <div class="flex items-center gap-3 rounded-control border border-border bg-surface p-3">
                    <span class="size-8 shrink-0 rounded-full border border-border shadow-2xs" x-bind:style="`background:${brandSwatch}`"></span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-fg" x-text="name || 'My theme'"></p>
                        <p class="truncate text-xs text-fg-muted tabular-nums" x-text="brandSwatch"></p>
                        <p class="truncate font-mono text-xs text-fg-muted tabular-nums uppercase" x-text="hex"></p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 pt-1">
                    <x-ui.button type="button" size="sm" x-on:click="useAsTheme()">
                        Use as my theme
                    </x-ui.button>
                    <x-ui.button type="button" variant="secondary" size="sm" x-on:click="clearTheme()">
                        Back to built-in
                    </x-ui.button>
                    <x-ui.button type="button" variant="ghost" size="sm" x-on:click="reset()">
                        Reset
                    </x-ui.button>
                </div>

                <p
                    class="text-xs text-fg-muted leading-relaxed"
                    x-show="active"
                    x-cloak
                >
                    Your theme is active and available in the header switcher as
                    <span class="font-medium text-fg" x-text="name || 'My theme'"></span>.
                </p>
            </div>

            <div
                class="overflow-hidden rounded-card border border-border bg-surface shadow-2xs"
                x-bind:style="previewStyle"
            >
                <div class="border-b border-border bg-surface-raised px-5 py-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-fg-muted">Live preview</p>
                    <p class="mt-1 text-sm font-semibold tracking-tight text-fg text-balance">
                        Brand-driven chrome without leaving semantic utilities
                    </p>
                </div>

                <div class="space-y-5 bg-surface p-5">
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui.button size="sm">Primary</x-ui.button>
                            <x-ui.button variant="secondary" size="sm">Secondary</x-ui.button>
                            <x-ui.button variant="outline" size="sm">Outline</x-ui.button>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui.badge variant="solid" color="brand" size="sm">brand</x-ui.badge>
                            <x-ui.badge variant="solid" color="success" size="sm">success</x-ui.badge>
                            <x-ui.badge variant="solid" color="warning" size="sm">warning</x-ui.badge>
                            <x-ui.badge variant="solid" color="danger" size="sm">danger</x-ui.badge>
                        </div>
                    </div>

                    <x-ui.alert variant="info" title="Scoped preview">
                        Sliders rewrite <code class="rounded bg-surface-sunken px-1 text-xs">--ui-brand</code> here. Use as my theme applies it across the docs site.
                    </x-ui.alert>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <x-ui.input label="Workspace name" name="palette-demo-name" placeholder="Acme Ops" />
                        <x-ui.select label="Plan" name="palette-demo-plan">
                            <option>Starter</option>
                            <option selected>Growth</option>
                            <option>Scale</option>
                        </x-ui.select>
                    </div>

                    <div class="rounded-card border border-border bg-surface-raised p-4 shadow-2xs">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold tracking-tight text-fg">Invoice #1042</p>
                                <p class="mt-0.5 text-xs text-fg-muted tabular-nums">Due in 3 days</p>
                            </div>
                            <x-ui.badge color="warning" size="sm" dot>Pending</x-ui.badge>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <x-ui.button size="sm">Collect payment</x-ui.button>
                            <x-ui.button variant="ghost" size="sm">Remind</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-card border border-border bg-surface-raised p-5 shadow-2xs">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm font-semibold tracking-tight text-fg">Copy into your app</h3>
                    <p class="mt-1 text-xs text-fg-muted leading-relaxed">
                        Paste under a <code class="rounded bg-surface-sunken px-1">[data-theme='custom']</code> block, or override <code class="rounded bg-surface-sunken px-1">:root</code>.
                    </p>
                </div>
                <x-ui.button type="button" variant="secondary" size="sm" x-on:click="copyCss()">
                    <span x-text="copied ? 'Copied' : 'Copy CSS'"></span>
                </x-ui.button>
            </div>
            <pre class="docs-code mt-4 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg"><code x-text="`[data-theme='custom'] {\n${exportCss}\n}`"></code></pre>
        </div>
    </section>

    <div id="token-samples" class="mt-12 space-y-4 rounded-card border border-border bg-surface-raised p-6 shadow-2xs">
        <h2 class="text-lg font-semibold tracking-tight text-fg">Token samples</h2>
        <div class="flex flex-wrap gap-3">
            <span class="rounded-pill bg-brand px-3 py-1 text-sm text-on-brand">brand</span>
            <span class="rounded-pill bg-success px-3 py-1 text-sm text-on-success">success</span>
            <span class="rounded-pill bg-warning px-3 py-1 text-sm text-on-warning">warning</span>
            <span class="rounded-pill bg-danger px-3 py-1 text-sm text-on-danger">danger</span>
            <span class="rounded-pill bg-info px-3 py-1 text-sm text-on-info">info</span>
        </div>
        <div class="grid gap-3 sm:grid-cols-3">
            <div class="rounded-card border border-border bg-surface p-4 text-sm">surface</div>
            <div class="rounded-card border border-border bg-surface-raised p-4 text-sm shadow-md">surface-raised</div>
            <div class="rounded-card border border-border bg-surface-sunken p-4 text-sm">surface-sunken</div>
        </div>
    </div>
</div>
@endsection
