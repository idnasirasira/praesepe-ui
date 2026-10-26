@extends('layouts.docs')

@section('title', 'Icons · '.config('ui-docs.name'))
@section('meta_description', 'Operational inline SVG icons shipped with Praesepe UI, plus how to use Heroicons or any other SVG in component slots.')

@section('toc')
    <x-docs.toc :items="[
        ['id' => 'built-in', 'label' => 'Built-in set'],
        ['id' => 'usage', 'label' => 'Usage'],
        ['id' => 'bring-your-own', 'label' => 'Bring your own'],
        ['id' => 'a11y', 'label' => 'Accessibility'],
    ]" />
@endsection

@php
    $usageExample = <<<'BLADE'
<x-ui.button size="sm">
    <x-icons.search class="size-3.5 shrink-0" />
    Search
</x-ui.button>

<x-ui.input name="q" placeholder="Find invoices">
    <x-slot:leadingIcon>
        <x-icons.search class="size-4 shrink-0" />
    </x-slot:leadingIcon>
</x-ui.input>
BLADE;

    $byoExample = <<<'BLADE'
<!-- Example: Heroicons-style path pasted into a control -->
<x-ui.button variant="outline" size="sm">
    <svg class="size-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
    New invoice
</x-ui.button>
BLADE;
@endphp

@section('content')
<x-docs.article>
    <h1>Icons</h1>
    <p>
        Praesepe ships a small operational icon set as inline Blade SVGs under
        <code class="rounded bg-surface-sunken px-1 text-sm">resources/views/components/icons</code>.
        It is not an icon foundry. For product icons beyond this set, use whatever pack you prefer.
    </p>

    <h2 id="built-in">Built-in set</h2>
    <p>
        {{ count($icons) }} icons used by docs chrome and UI primitives. Click a card to copy the Blade tag.
    </p>

    <div class="mt-6 grid gap-3 sm:grid-cols-2 md:grid-cols-3">
        @foreach ($icons as $icon)
            <button
                type="button"
                class="group flex flex-col items-start gap-3 rounded-card border border-border bg-surface-raised p-4 text-left shadow-2xs transition-colors duration-150 hover:border-border-strong hover:bg-surface-sunken focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                x-data="{ copied: false }"
                x-on:click="
                    navigator.clipboard.writeText(@js($icon['usage'])).then(() => {
                        copied = true;
                        setTimeout(() => copied = false, 1600);
                    })
                "
                x-bind:aria-label="copied ? 'Copied {{ $icon['usage'] }}' : 'Copy {{ $icon['usage'] }}'"
            >
                <span class="inline-flex size-9 items-center justify-center rounded-control border border-border bg-surface text-fg shadow-2xs">
                    <x-dynamic-component :component="$icon['component']" class="size-5 shrink-0" />
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-semibold tracking-tight text-fg">{{ $icon['name'] }}</span>
                    <span class="mt-1 block truncate font-mono text-[11px] text-fg-muted">x-icons.{{ $icon['name'] }}</span>
                </span>
                <span class="text-[11px] font-medium text-fg-subtle" x-text="copied ? 'Copied' : 'Copy tag'"></span>
            </button>
        @endforeach
    </div>

    <h2 id="usage">Usage</h2>
    <p>
        Prefer long-form sizing with <code class="rounded bg-surface-sunken px-1 text-sm">size-*</code> and
        <code class="rounded bg-surface-sunken px-1 text-sm">shrink-0</code> inside flex rows.
        Optical defaults: <code class="rounded bg-surface-sunken px-1 text-sm">size-3.5</code> in
        <code class="rounded bg-surface-sunken px-1 text-sm">sm</code> controls,
        <code class="rounded bg-surface-sunken px-1 text-sm">size-4</code> in
        <code class="rounded bg-surface-sunken px-1 text-sm">md</code>.
    </p>
    <x-docs.code-block language="blade" :code="$usageExample" />

    <h2 id="bring-your-own">Bring your own</h2>
    <p>
        Praesepe does not depend on an icon package. Drop any SVG into a slot, or install a pack in your app.
        Common choices: <a class="text-brand underline underline-offset-2" href="https://heroicons.com" rel="noopener noreferrer" target="_blank">Heroicons</a>,
        Lucide, Phosphor, or hand-authored marks.
    </p>
    <ul>
        <li>Pass custom SVG through named slots such as <code class="rounded bg-surface-sunken px-1 text-sm">leadingIcon</code>, <code class="rounded bg-surface-sunken px-1 text-sm">icon</code>, or button children.</li>
        <li>Keep stroke icons around 1.5 to 2px so they match control density.</li>
        <li>Use <code class="rounded bg-surface-sunken px-1 text-sm">currentColor</code> so icons follow <code class="rounded bg-surface-sunken px-1 text-sm">text-*</code> utilities.</li>
        <li>If you standardize on Heroicons, copy only the glyphs you need into your app. Do not add a Heroicons package to Praesepe itself.</li>
    </ul>
    <x-docs.code-block language="blade" :code="$byoExample" />

    <h2 id="a11y">Accessibility</h2>
    <ul>
        <li>Decorative icons default to <code class="rounded bg-surface-sunken px-1 text-sm">aria-hidden="true"</code>.</li>
        <li>Icon-only controls need an accessible name on the button or link (<code class="rounded bg-surface-sunken px-1 text-sm">aria-label</code>).</li>
        <li>Do not rely on color alone. Pair status icons with text labels in tables and alerts when meaning matters.</li>
    </ul>

    <div class="docs-cta">
        <x-docs.cta />
    </div>
</x-docs.article>
@endsection
