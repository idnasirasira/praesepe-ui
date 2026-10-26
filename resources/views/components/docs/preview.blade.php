@props([
    'title' => 'Preview',
    'description' => null,
    'html' => '',
    'blade' => '',
    'preview' => '',
])

@php
    $panelId = 'preview-'.Illuminate\Support\Str::slug($title).'-'.Illuminate\Support\Str::random(4);
@endphp

<section
    class="overflow-hidden rounded-card border border-border bg-surface-raised shadow-sm ring-1 ring-black/5"
    x-data="{
        tab: 'preview',
        previewDark: false,
        viewport: 'full',
        theme: document.documentElement.getAttribute('data-theme') || 'praesepe',
        copied: false,
        widths: {
            full: '100%',
            tablet: '768px',
            mobile: '375px',
        },
        codeForTab() {
            if (this.tab === 'html') return this.$refs.htmlCode?.textContent || '';
            return this.$refs.bladeCode?.textContent || '';
        },
        async copySnippet() {
            const value = this.tab === 'html'
                ? this.$refs.htmlCode?.textContent || ''
                : this.$refs.bladeCode?.textContent || '';
            try {
                await navigator.clipboard.writeText(value.trim());
                this.copied = true;
                setTimeout(() => this.copied = false, 1800);
            } catch (e) {
                this.copied = false;
            }
        }
    }"
    x-on:ui-theme-change.window="theme = $event.detail?.theme || theme"
>
    {{-- Studio toolbar --}}
    <div class="flex flex-col gap-3 border-b border-border bg-surface/80 px-3 py-3 backdrop-blur-sm sm:flex-row sm:items-center sm:justify-between sm:px-4">
        <div class="min-w-0">
            <h3 class="truncate text-sm font-semibold tracking-tight text-fg">{{ $title }}</h3>
            @if ($description)
                <p class="mt-0.5 truncate text-xs text-fg-muted leading-relaxed">{{ $description }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-2">
            {{-- Preview / Blade / HTML segmented control --}}
            <div
                class="inline-flex rounded-control border border-border bg-surface-sunken/60 p-0.5 text-xs shadow-2xs"
                role="tablist"
                aria-label="Preview or code"
            >
                <button
                    type="button"
                    role="tab"
                    class="rounded-[calc(var(--ui-radius-control)-2px)] px-2.5 py-1.5 font-medium transition-colors duration-150"
                    x-bind:class="tab === 'preview' ? 'bg-surface-raised text-fg shadow-2xs' : 'text-fg-muted hover:text-fg'"
                    x-bind:aria-selected="(tab === 'preview').toString()"
                    x-on:click="tab = 'preview'"
                >
                    Preview
                </button>
                <button
                    type="button"
                    role="tab"
                    class="rounded-[calc(var(--ui-radius-control)-2px)] px-2.5 py-1.5 font-medium transition-colors duration-150"
                    x-bind:class="tab === 'blade' ? 'bg-surface-raised text-fg shadow-2xs' : 'text-fg-muted hover:text-fg'"
                    x-bind:aria-selected="(tab === 'blade').toString()"
                    x-on:click="tab = 'blade'"
                >
                    Blade
                </button>
                <button
                    type="button"
                    role="tab"
                    class="rounded-[calc(var(--ui-radius-control)-2px)] px-2.5 py-1.5 font-medium transition-colors duration-150"
                    x-bind:class="tab === 'html' ? 'bg-surface-raised text-fg shadow-2xs' : 'text-fg-muted hover:text-fg'"
                    x-bind:aria-selected="(tab === 'html').toString()"
                    x-on:click="tab = 'html'"
                >
                    HTML + Alpine
                </button>
            </div>

            {{-- Viewport resizer (desktop only) --}}
            <div
                class="hidden rounded-control border border-border bg-surface-sunken/60 p-0.5 text-xs shadow-2xs md:inline-flex"
                role="group"
                aria-label="Preview width"
                x-show="tab === 'preview'"
            >
                <button
                    type="button"
                    class="rounded-[calc(var(--ui-radius-control)-2px)] px-2 py-1.5 transition-colors duration-150"
                    x-bind:class="viewport === 'full' ? 'bg-surface-raised font-medium text-fg shadow-2xs' : 'text-fg-muted hover:text-fg'"
                    x-on:click="viewport = 'full'"
                    title="Desktop 100%"
                >
                    Desktop
                </button>
                <button
                    type="button"
                    class="rounded-[calc(var(--ui-radius-control)-2px)] px-2 py-1.5 transition-colors duration-150"
                    x-bind:class="viewport === 'tablet' ? 'bg-surface-raised font-medium text-fg shadow-2xs' : 'text-fg-muted hover:text-fg'"
                    x-on:click="viewport = 'tablet'"
                    title="Tablet 768px"
                >
                    Tablet
                </button>
                <button
                    type="button"
                    class="rounded-[calc(var(--ui-radius-control)-2px)] px-2 py-1.5 transition-colors duration-150"
                    x-bind:class="viewport === 'mobile' ? 'bg-surface-raised font-medium text-fg shadow-2xs' : 'text-fg-muted hover:text-fg'"
                    x-on:click="viewport = 'mobile'"
                    title="Mobile 375px"
                >
                    Mobile
                </button>
            </div>

            {{-- Local canvas dark toggle --}}
            <button
                type="button"
                class="inline-flex items-center gap-1.5 rounded-control border border-border bg-surface px-2.5 py-1.5 text-xs font-medium text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken"
                x-show="tab === 'preview'"
                x-on:click="previewDark = !previewDark"
                x-bind:aria-pressed="previewDark.toString()"
                x-bind:aria-label="previewDark ? 'Switch preview canvas to light' : 'Switch preview canvas to dark'"
            >
                <span x-show="!previewDark"><x-icons.moon class="size-3.5 shrink-0" /></span>
                <span x-show="previewDark" x-cloak><x-icons.sun class="size-3.5 shrink-0" /></span>
                <span class="hidden sm:inline" x-text="previewDark ? 'Canvas light' : 'Canvas dark'"></span>
            </button>

            {{-- One-click copy --}}
            <div class="relative">
                <button
                    type="button"
                    class="inline-flex items-center gap-1.5 rounded-control border border-border bg-surface px-2.5 py-1.5 text-xs font-medium text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    x-on:click="copySnippet()"
                    x-bind:aria-label="copied ? 'Copied' : 'Copy snippet'"
                >
                    <span x-show="!copied" class="inline-flex items-center gap-1.5">
                        <x-icons.copy class="size-3.5 shrink-0" />
                        <span class="hidden sm:inline">Copy</span>
                    </span>
                    <span x-show="copied" x-cloak class="inline-flex items-center gap-1.5 text-success">
                        <x-icons.check class="size-3.5 shrink-0" />
                        <span class="hidden sm:inline">Copied</span>
                    </span>
                </button>
                <span
                    class="pointer-events-none absolute -top-8 left-1/2 z-10 -translate-x-1/2 rounded-control bg-fg px-2 py-1 text-[10px] font-medium text-fg-inverse shadow-md"
                    x-show="copied"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                >
                    Copied!
                </span>
                <span class="sr-only" aria-live="polite" x-text="copied ? 'Snippet copied to clipboard' : ''"></span>
            </div>
        </div>
    </div>

    {{-- Preview stage --}}
    <div
        x-show="tab === 'preview'"
        role="tabpanel"
        id="{{ $panelId }}-preview"
        class="overflow-x-auto bg-surface-sunken/40 bg-[radial-gradient(var(--ui-border)_1px,transparent_1px)] [background-size:16px_16px] p-6 sm:p-10"
    >
        <div
            class="mx-auto overflow-hidden rounded-card border border-border bg-surface text-fg shadow-sm transition-[max-width] duration-300 ease-out"
            x-bind:class="previewDark ? 'dark' : ''"
            x-bind:data-theme="theme"
            x-bind:style="'max-width:' + widths[viewport]"
        >
            <div class="bg-surface p-4 text-fg sm:p-6">
                {!! $preview !!}
            </div>
        </div>
    </div>

    {{-- Blade source --}}
    <div x-show="tab === 'blade'" x-cloak role="tabpanel" id="{{ $panelId }}-blade">
        <pre tabindex="0" class="docs-code max-h-[28rem] overflow-auto bg-surface-sunken/30 p-4 text-xs leading-relaxed text-fg" role="region" aria-label="{{ $title }} Blade source"><code x-ref="bladeCode" class="language-blade">{{ $blade }}</code></pre>
    </div>

    {{-- HTML source --}}
    <div x-show="tab === 'html'" x-cloak role="tabpanel" id="{{ $panelId }}-html">
        <pre tabindex="0" class="docs-code max-h-[28rem] overflow-auto bg-surface-sunken/30 p-4 text-xs leading-relaxed text-fg" role="region" aria-label="{{ $title }} HTML source"><code x-ref="htmlCode" class="language-html">{{ $html }}</code></pre>
    </div>
</section>
