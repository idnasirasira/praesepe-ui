@props([
    'title' => 'Preview',
    'description' => null,
    'html' => '',
    'blade' => '',
    'preview' => '',
])

<section
    class="overflow-hidden rounded-card border border-border bg-surface-raised"
    x-data="{
        tab: 'html',
        previewDark: false,
        viewport: 'full',
        widths: {
            full: '100%',
            tablet: '768px',
            mobile: '375px',
        }
    }"
>
    <div class="flex flex-wrap items-start justify-between gap-3 border-b border-border px-4 py-3">
        <div>
            <h3 class="text-sm font-semibold text-fg">{{ $title }}</h3>
            @if ($description)
                <p class="mt-1 text-sm text-fg-muted">{{ $description }}</p>
            @endif
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <div class="inline-flex rounded-control border border-border p-0.5 text-xs" role="group" aria-label="Preview width">
                <button type="button" class="rounded-[calc(var(--ui-radius-control)-2px)] px-2 py-1" x-bind:class="viewport === 'full' ? 'bg-surface-sunken font-medium' : ''" x-on:click="viewport = 'full'">Full</button>
                <button type="button" class="rounded-[calc(var(--ui-radius-control)-2px)] px-2 py-1" x-bind:class="viewport === 'tablet' ? 'bg-surface-sunken font-medium' : ''" x-on:click="viewport = 'tablet'">Tablet</button>
                <button type="button" class="rounded-[calc(var(--ui-radius-control)-2px)] px-2 py-1" x-bind:class="viewport === 'mobile' ? 'bg-surface-sunken font-medium' : ''" x-on:click="viewport = 'mobile'">Mobile</button>
            </div>
            <button
                type="button"
                class="inline-flex items-center gap-1 rounded-control border border-border px-2 py-1 text-xs"
                x-on:click="previewDark = !previewDark"
                x-bind:aria-pressed="previewDark.toString()"
            >
                <span x-text="previewDark ? 'Preview light' : 'Preview dark'"></span>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto bg-surface-sunken p-4">
        <div
            class="mx-auto overflow-hidden rounded-control border border-border bg-surface p-6 transition-[max-width] duration-200"
            x-bind:class="previewDark ? 'dark' : ''"
            x-bind:style="'max-width:' + widths[viewport]"
        >
            <div class="bg-surface text-fg">
                {!! $preview !!}
            </div>
        </div>
    </div>

    <div class="border-t border-border">
        <div class="flex items-center justify-between gap-2 border-b border-border px-4">
            <div class="flex gap-1" role="tablist" aria-label="Code format">
                <button
                    type="button"
                    role="tab"
                    class="border-b-2 px-3 py-2 text-sm"
                    x-bind:class="tab === 'html' ? 'border-brand text-fg' : 'border-transparent text-fg-muted'"
                    x-bind:aria-selected="(tab === 'html').toString()"
                    x-on:click="tab = 'html'"
                >
                    HTML + Alpine
                </button>
                <button
                    type="button"
                    role="tab"
                    class="border-b-2 px-3 py-2 text-sm"
                    x-bind:class="tab === 'blade' ? 'border-brand text-fg' : 'border-transparent text-fg-muted'"
                    x-bind:aria-selected="(tab === 'blade').toString()"
                    x-on:click="tab = 'blade'"
                >
                    Blade
                </button>
            </div>
            <div class="py-2">
                <span x-show="tab === 'html'"><x-docs.copy-button :code="$html" /></span>
                <span x-show="tab === 'blade'" x-cloak><x-docs.copy-button :code="$blade" /></span>
            </div>
        </div>

        <div role="tabpanel" x-show="tab === 'html'">
            <pre class="overflow-x-auto p-4 text-xs leading-relaxed text-fg"><code>{{ $html }}</code></pre>
        </div>
        <div role="tabpanel" x-show="tab === 'blade'" x-cloak>
            <pre class="overflow-x-auto p-4 text-xs leading-relaxed text-fg"><code>{{ $blade }}</code></pre>
        </div>
    </div>
</section>
