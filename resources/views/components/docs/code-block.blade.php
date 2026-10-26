@props([
    'code' => '',
    'language' => null,
    'label' => 'Copy code',
    'wrap' => false,
    'tabular' => false,
])

@php
    $source = trim($slot->isNotEmpty() ? (string) $slot : (string) $code);
    $languageClass = filled($language) ? 'language-'.$language : null;
@endphp

<div
    {{ $attributes->class('docs-code-block relative') }}
    x-data="{
        copied: false,
        code: @js($source),
        async copy() {
            try {
                await navigator.clipboard.writeText(this.code);
                this.copied = true;
                setTimeout(() => this.copied = false, 1800);
            } catch (e) {
                this.copied = false;
            }
        }
    }"
>
    <div class="absolute end-2 top-2 z-10">
        <div class="relative">
            <button
                type="button"
                class="inline-flex size-7 items-center justify-center rounded-control border border-border bg-surface text-fg shadow-2xs transition-colors duration-150 hover:bg-surface-sunken focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                x-on:click="copy()"
                x-bind:aria-label="copied ? 'Copied' : @js($label)"
                title="{{ $label }}"
            >
                <span x-show="!copied"><x-icons.copy class="size-3.5 shrink-0" /></span>
                <span x-show="copied" x-cloak class="text-success"><x-icons.check class="size-3.5 shrink-0" /></span>
            </button>
            <span
                class="pointer-events-none absolute -top-8 left-1/2 z-10 -translate-x-1/2 whitespace-nowrap rounded-control bg-fg px-2 py-1 text-[10px] font-medium text-fg-inverse shadow-md"
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
            <span class="sr-only" aria-live="polite" x-text="copied ? 'Code copied to clipboard' : ''"></span>
        </div>
    </div>

    <pre @class([
        'docs-code overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 pe-12 text-xs text-fg',
        'whitespace-pre-wrap' => $wrap,
        'tabular-nums' => $tabular,
    ])><code @class([$languageClass])>{{ $source }}</code></pre>
</div>
