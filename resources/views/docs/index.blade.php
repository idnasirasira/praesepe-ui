@extends('layouts.docs')

@section('title', 'Installation · '.config('ui-docs.name'))
@section('meta_description', 'Install Praesepe UI with the CLI, MCP, or manual copy into Laravel, Tailwind CSS 4, and Alpine.js 3.')

@section('toc')
    <x-docs.toc :items="[
        ['id' => 'cli', 'label' => 'CLI'],
        ['id' => 'mcp', 'label' => 'MCP for agents'],
        ['id' => 'requirements', 'label' => 'Requirements'],
        ['id' => 'manual', 'label' => 'Manual setup'],
        ['id' => 'livewire', 'label' => 'Livewire notes'],
    ]" />
@endsection

@php
    $cliPackage = (string) config('ui-docs.cli_package');
    $registryUrl = (string) config('ui-docs.registry_url');
    $cliPublished = (bool) config('ui-docs.cli_published', false);

    $cliInit = "npx {$cliPackage}@latest init\nnpx {$cliPackage}@latest add button modal";

    $cliFromClone = <<<'BASH'
git clone https://github.com/idnasirasira/praesepe-ui.git
cd praesepe-ui
node packages/cli/bin/praesepe-ui.js init --cwd /path/to/your-laravel-app --registry https://ui.praesepe.id/r
node packages/cli/bin/praesepe-ui.js add button modal --cwd /path/to/your-laravel-app --registry https://ui.praesepe.id/r
BASH;

    $source = static fn (string $path): string => '@'.'source "'.$path.'";';

    $tailwindSource = implode("\n", [
        '@import "tailwindcss";',
        '@import "./theme.css";',
        '',
        $source('../views/**/*.blade.php'),
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
        Praesepe UI is a copy-paste component library. Files land in your Laravel app so you own and edit them.
        Prefer the CLI for humans and MCP for coding agents. There is no Composer vendor UI package in v1.
    </p>

    <h2 id="cli">CLI</h2>
    @if ($cliPublished)
        <p>
            From a Laravel app that already has Tailwind CSS v4 via Vite:
        </p>
        <x-docs.code-block language="bash" :code="$cliInit" />
    @else
        <p>
            The npm package <code class="rounded bg-surface-sunken px-1 text-sm">{{ $cliPackage }}</code> is not published yet.
            Until it is live, run the CLI from a clone (or use MCP / the HTTP registry below).
        </p>
        <x-docs.code-block language="bash" :code="$cliFromClone" />
        <p class="text-fg-muted">
            After publish, the short form will be
            <code class="rounded bg-surface-sunken px-1 text-sm">npx {{ $cliPackage }}@latest init</code>.
        </p>
    @endif
    <ul>
        <li><code class="rounded bg-surface-sunken px-1 text-sm">init</code> writes <code class="rounded bg-surface-sunken px-1 text-sm">components.json</code>, copies <code class="rounded bg-surface-sunken px-1 text-sm">theme.css</code>, and wires your app CSS</li>
        <li><code class="rounded bg-surface-sunken px-1 text-sm">add</code> copies Blade primitives and required icons from the public registry</li>
        <li>Default registry: <a class="text-brand underline underline-offset-2" href="{{ route('registry.home') }}"><code class="rounded bg-surface-sunken px-1 text-sm tabular-nums">{{ $registryUrl }}</code></a></li>
    </ul>
    <p>
        Then install Alpine if needed (<code class="rounded bg-surface-sunken px-1 text-sm">npm install alpinejs @alpinejs/focus</code>) and register the focus plugin once.
    </p>

    <h2 id="mcp">MCP for coding agents</h2>
    <p>
        Point Cursor at <code class="rounded bg-surface-sunken px-1 text-sm tabular-nums">{{ config('ui-docs.mcp_url') }}</code>.
        Agents should call <code class="rounded bg-surface-sunken px-1 text-sm">get_init_files</code>, then <code class="rounded bg-surface-sunken px-1 text-sm">get_install_files</code>, then <code class="rounded bg-surface-sunken px-1 text-sm">get_snippet</code>.
        Full setup:
        <a class="text-brand underline underline-offset-2" href="{{ route('docs.mcp') }}">MCP for agents</a>.
    </p>

    <h2 id="requirements">Requirements</h2>
    <ul>
        <li>Laravel 12 or 13</li>
        <li>PHP 8.4+</li>
        <li>Tailwind CSS 4 with <code class="rounded bg-surface-sunken px-1 text-sm">@tailwindcss/vite</code></li>
        <li>Alpine.js 3 with <code class="rounded bg-surface-sunken px-1 text-sm">@alpinejs/focus</code></li>
    </ul>

    <h2 id="manual">Manual setup</h2>
    <p>
        Use this when you cannot run the CLI. Import tokens, scan Blade views, then copy components from the registry or this repository.
    </p>
    <h3 id="tailwind">Tailwind v4 source scanning</h3>
    <x-docs.code-block language="css" :code="$tailwindSource" />
    <h3 id="theme">Theme tokens</h3>
    <p>
        Download <a class="text-brand underline underline-offset-2" href="{{ route('registry.theme') }}">theme.css</a>
        into <code class="rounded bg-surface-sunken px-1 text-sm">resources/css/theme.css</code>.
        Semantic tokens use <code class="rounded bg-surface-sunken px-1 text-sm">--ui-*</code> mapped with <code class="rounded bg-surface-sunken px-1 text-sm">@theme inline</code>.
        See <a class="text-brand underline underline-offset-2" href="{{ route('docs.theming') }}">Theming</a>.
    </p>
    <h3 id="alpine">Alpine setup</h3>
    <x-docs.code-block language="javascript" :code="$alpineSource" />
    <h3 id="components">Components</h3>
    <p>
        Fetch a package from <code class="rounded bg-surface-sunken px-1 text-sm tabular-nums">{{ $registryUrl }}/{slug}.json</code>
        and write each <code class="rounded bg-surface-sunken px-1 text-sm">files[].path</code>, or copy from
        <code class="rounded bg-surface-sunken px-1 text-sm">resources/views/components/ui/</code> in this repo.
    </p>

    <h2 id="livewire">Livewire notes</h2>
    <p>
        Praesepe UI does not require Livewire. If your app already uses Livewire, do not start a second Alpine instance. Livewire bundles Alpine; register the focus plugin on the existing Alpine global before Livewire boots, and prefer long-form directives in Blade to avoid attribute collisions.
    </p>

    <div class="docs-cta">
        <x-docs.cta />
    </div>
</x-docs.article>
@endsection
