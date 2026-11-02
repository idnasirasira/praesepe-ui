<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Praesepe UI install registry</title>
    <meta name="description" content="HTTP install registry for Praesepe UI Blade components.">
    <style>
        :root { color-scheme: light dark; }
        body { font-family: ui-sans-serif, system-ui, sans-serif; margin: 0; padding: 2rem; line-height: 1.5; }
        main { max-width: 48rem; margin: 0 auto; }
        h1 { font-size: 1.5rem; letter-spacing: -0.02em; margin: 0 0 0.5rem; }
        p, li { color: #555; }
        @media (prefers-color-scheme: dark) { p, li { color: #bbb; } }
        code, a { word-break: break-all; }
        ul { padding-left: 1.25rem; }
        .muted { font-size: 0.875rem; }
        .grid { display: grid; gap: 0.35rem; margin-top: 1rem; }
    </style>
</head>
<body>
<main>
    <h1>Praesepe UI registry</h1>
    <p class="muted">Version {{ $version }} · machine-readable install API for the CLI and MCP.</p>

    <p>
        Human docs:
        <a href="{{ route('docs.index') }}">Installation</a>
        ·
        <a href="{{ route('docs.mcp') }}">MCP</a>
    </p>

    <h2>Endpoints</h2>
    <ul>
        <li><a href="{{ route('registry.index') }}"><code>/r/index.json</code></a></li>
        <li><a href="{{ route('registry.schema') }}"><code>/r/schema.json</code></a></li>
        <li><a href="{{ route('registry.theme') }}"><code>/r/styles/theme.css</code></a></li>
        <li><code>/r/{slug}.json</code> (example: <a href="{{ url('/r/button.json') }}">button</a>)</li>
    </ul>

    <h2>Install</h2>
    @if ($cliPublished)
        <p>CLI: <code>npx {{ $cliPackage }}@latest init</code></p>
    @else
        <p>
            The npm CLI package is not published yet. Until then, use MCP
            (<code>{{ $mcpUrl }}</code>) or fetch JSON packages below and write the files into your Laravel app.
        </p>
    @endif

    <h2>Components ({{ count($items) }})</h2>
    <div class="grid">
        @foreach ($items as $item)
            <div>
                <a href="{{ url('/r/'.$item['slug'].'.json') }}"><code>{{ $item['slug'] }}</code></a>
                <span class="muted">{{ $item['name'] }}</span>
            </div>
        @endforeach
    </div>
</main>
</body>
</html>
