@extends('layouts.docs')

@section('title', 'Installation · '.config('ui-docs.name'))
@section('meta_description', 'Install Praesepe UI with Laravel, Tailwind CSS 4, and Alpine.js 3.')

@section('toc')
    <x-docs.toc :items="[
        ['id' => 'requirements', 'label' => 'Requirements'],
        ['id' => 'tailwind', 'label' => 'Tailwind source scanning'],
        ['id' => 'theme', 'label' => 'Theme tokens'],
        ['id' => 'alpine', 'label' => 'Alpine setup'],
        ['id' => 'livewire', 'label' => 'Livewire notes'],
    ]" />
@endsection

@section('content')
<article class="prose-docs mx-auto max-w-3xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Installation</h1>
    <p class="mt-3 text-fg-muted leading-relaxed">
        Praesepe UI is a copy-paste component library. Copy the Blade components, tokens, and Alpine patterns into your Laravel app.
    </p>

    <h2 id="requirements" class="mt-10 text-xl font-semibold tracking-tight text-fg">Requirements</h2>
    <ul class="mt-3 list-disc space-y-2 pl-5 text-fg">
        <li>Laravel 12 or 13</li>
        <li>PHP 8.3+</li>
        <li>Tailwind CSS 4 with <code class="rounded bg-surface-sunken px-1 text-sm">@tailwindcss/vite</code></li>
        <li>Alpine.js 3 with <code class="rounded bg-surface-sunken px-1 text-sm">@alpinejs/focus</code></li>
    </ul>

    <h2 id="tailwind" class="mt-10 text-xl font-semibold tracking-tight text-fg">Tailwind v4 source scanning</h2>
    <p class="mt-3 text-fg-muted leading-relaxed">
        Declare explicit <code class="rounded bg-surface-sunken px-1 text-sm">@source</code> paths so classes used only in snippets and metadata are never purged.
    </p>
    <pre class="docs-code mt-4 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg"><code class="language-css">@import "tailwindcss";
@import "./theme.css";

@source "../views/**/*.blade.php";
@source "../snippets/**/*.html";
@source "../docs/**/*.php";</code></pre>

    <h2 id="theme" class="mt-10 text-xl font-semibold tracking-tight text-fg">Theme tokens</h2>
    <p class="mt-3 text-fg-muted leading-relaxed">
        Import <code class="rounded bg-surface-sunken px-1 text-sm">theme.css</code> and map semantic <code class="rounded bg-surface-sunken px-1 text-sm">--ui-*</code> variables with <code class="rounded bg-surface-sunken px-1 text-sm">@theme inline</code>. See <a class="text-brand underline underline-offset-2" href="{{ route('docs.theming') }}">Theming</a>.
    </p>

    <h2 id="alpine" class="mt-10 text-xl font-semibold tracking-tight text-fg">Alpine setup</h2>
    <pre class="docs-code mt-4 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg"><code class="language-javascript">import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);
window.Alpine = Alpine;
Alpine.start();</code></pre>

    <h2 id="livewire" class="mt-10 text-xl font-semibold tracking-tight text-fg">Livewire notes</h2>
    <p class="mt-3 text-fg-muted leading-relaxed">
        Praesepe UI does not require Livewire. If your app already uses Livewire, do not start a second Alpine instance. Livewire bundles Alpine; register the focus plugin on the existing Alpine global before Livewire boots, and prefer long-form directives in Blade to avoid attribute collisions.
    </p>

    <h2 id="mcp" class="mt-10 text-xl font-semibold tracking-tight text-fg">MCP for coding agents</h2>
    <p class="mt-3 text-fg-muted leading-relaxed">
        Agents can list components and copy snippets via Laravel MCP. Connect Cursor over HTTP or local stdio. See
        <a class="text-brand underline underline-offset-2" href="{{ route('docs.mcp') }}">MCP for agents</a>.
    </p>

    <div class="mt-12">
        <x-docs.cta />
    </div>
</article>
@endsection
