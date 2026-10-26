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

@php
    $source = static fn (string $path): string => '@'.'source "'.$path.'";';

    $tailwindSource = implode("\n", [
        '@import "tailwindcss";',
        '@import "./theme.css";',
        '',
        $source('../views/**/*.blade.php'),
        $source('../snippets/**/*.html'),
        $source('../docs/**/*.php'),
    ]);

    $alpineSource = <<<'JS'
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);
window.Alpine = Alpine;
Alpine.start();
JS;
@endphp

@section('content')
<x-docs.article>
    <h1>Installation</h1>
    <p>
        Praesepe UI is a copy-paste component library. Copy the Blade components, tokens, and Alpine patterns into your Laravel app.
    </p>

    <h2 id="requirements">Requirements</h2>
    <ul>
        <li>Laravel 12 or 13</li>
        <li>PHP 8.3+</li>
        <li>Tailwind CSS 4 with <code class="rounded bg-surface-sunken px-1 text-sm">@tailwindcss/vite</code></li>
        <li>Alpine.js 3 with <code class="rounded bg-surface-sunken px-1 text-sm">@alpinejs/focus</code></li>
    </ul>

    <h2 id="tailwind">Tailwind v4 source scanning</h2>
    <p>
        Declare explicit <code class="rounded bg-surface-sunken px-1 text-sm">@source</code> paths so classes used only in snippets and metadata are never purged.
    </p>
    <x-docs.code-block language="css" :code="$tailwindSource" />

    <h2 id="theme">Theme tokens</h2>
    <p>
        Import <code class="rounded bg-surface-sunken px-1 text-sm">theme.css</code> and map semantic <code class="rounded bg-surface-sunken px-1 text-sm">--ui-*</code> variables with <code class="rounded bg-surface-sunken px-1 text-sm">@theme inline</code>. See <a class="text-brand underline underline-offset-2" href="{{ route('docs.theming') }}">Theming</a>.
    </p>

    <h2 id="alpine">Alpine setup</h2>
    <p>
        Register Alpine and the focus plugin once in your app bundle.
    </p>
    <x-docs.code-block language="javascript" :code="$alpineSource" />

    <h2 id="livewire">Livewire notes</h2>
    <p>
        Praesepe UI does not require Livewire. If your app already uses Livewire, do not start a second Alpine instance. Livewire bundles Alpine; register the focus plugin on the existing Alpine global before Livewire boots, and prefer long-form directives in Blade to avoid attribute collisions.
    </p>

    <h2 id="mcp">MCP for coding agents</h2>
    <p>
        Agents can list components and copy snippets via Laravel MCP. Connect Cursor over HTTP or local stdio. See
        <a class="text-brand underline underline-offset-2" href="{{ route('docs.mcp') }}">MCP for agents</a>.
    </p>

    <div class="docs-cta">
        <x-docs.cta />
    </div>
</x-docs.article>
@endsection
