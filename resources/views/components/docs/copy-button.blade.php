@props([
    'code' => '',
    'label' => 'Copy code',
])

<div
    x-data="{
        copied: false,
        code: @js($code),
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
    {{ $attributes }}
>
    <button
        type="button"
        class="inline-flex items-center gap-1.5 rounded-control border border-border bg-surface px-2.5 py-1.5 text-xs font-medium text-fg hover:bg-surface-sunken"
        x-on:click="copy()"
        x-bind:aria-label="copied ? 'Copied' : @js($label)"
    >
        <span x-show="!copied"><x-icons.copy class="size-3.5" /></span>
        <span x-show="copied" x-cloak><x-icons.check class="size-3.5" /></span>
        <span x-text="copied ? 'Copied' : 'Copy'"></span>
    </button>
    <span class="sr-only" aria-live="polite" x-text="copied ? 'Code copied to clipboard' : ''"></span>
</div>
