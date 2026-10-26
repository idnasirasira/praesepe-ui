@extends('layouts.docs')

@section('title', 'MCP for agents · '.config('ui-docs.name'))
@section('meta_description', 'Connect Cursor or other MCP clients to the Praesepe UI component registry over HTTP or local stdio.')

@section('toc')
    <x-docs.toc :items="[
        ['id' => 'remote', 'label' => 'Remote HTTP'],
        ['id' => 'prompt', 'label' => 'Agent prompt'],
        ['id' => 'local', 'label' => 'Local stdio'],
        ['id' => 'tools', 'label' => 'Tools'],
        ['id' => 'workflow', 'label' => 'Agent workflow'],
    ]" />
@endsection

@section('content')
<article class="mx-auto max-w-3xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg text-balance">MCP for agents</h1>
    <p class="mt-3 text-fg-muted leading-relaxed text-pretty">
        Coding agents can discover Praesepe UI components through
        <a class="text-brand underline underline-offset-2" href="https://laravel.com/docs/mcp">Laravel MCP</a>.
        The registry is read-only: list, search, props, a11y notes, and copy-paste snippets.
        No authentication is required.
    </p>

    <h2 id="remote" class="mt-10 text-xl font-semibold tracking-tight text-fg">Remote HTTP</h2>
    <p class="mt-3 text-fg-muted leading-relaxed text-pretty">
        Point any MCP client that supports HTTP transport at the public production endpoint. No clone required.
    </p>
    <pre class="docs-code mt-4 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg tabular-nums"><code>{{ $mcpUrl }}</code></pre>

    <h3 class="mt-8 text-base font-semibold tracking-tight text-fg">Cursor</h3>
    <p class="mt-2 text-fg-muted leading-relaxed text-pretty">
        Add this in Cursor Settings → MCP (or the consuming project's private MCP config), then restart Cursor and enable
        <strong class="font-semibold text-fg">praesepe-ui</strong>.
        Editor config stays on your machine; it is not part of the Praesepe UI package.
    </p>
    <pre class="docs-code mt-4 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg"><code class="language-json">{
  "mcpServers": {
    "praesepe-ui": {
      "url": "{{ $mcpUrl }}"
    }
  }
}</code></pre>

    <h2 id="prompt" class="mt-10 text-xl font-semibold tracking-tight text-fg">Agent prompt</h2>
    <p class="mt-3 text-fg-muted leading-relaxed text-pretty">
        After the MCP server is enabled, paste this into Cursor Settings → Rules → User Rules
        (or your project's agent rules). Agents will call Praesepe tools instead of inventing markup.
    </p>
    <div class="mt-4 flex justify-end">
        <x-docs.copy-button :code="$agentPrompt" label="Copy user rule" />
    </div>
    <pre class="docs-code mt-2 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg whitespace-pre-wrap"><code>{{ $agentPrompt }}</code></pre>

    <h2 id="local" class="mt-10 text-xl font-semibold tracking-tight text-fg">Local stdio</h2>
    <p class="mt-3 text-fg-muted leading-relaxed text-pretty">
        Optional when you have this repo checked out and prefer stdio over HTTP. Add the snippet below to your private Cursor MCP settings.
        You do not run
        <code class="rounded bg-surface-sunken px-1 text-sm">mcp:start</code>
        by hand; Cursor starts it.
    </p>
    <pre class="docs-code mt-4 overflow-x-auto rounded-card border border-border bg-surface-sunken p-4 text-xs text-fg"><code class="language-json">{
  "mcpServers": {
    "praesepe-ui": {
      "type": "stdio",
      "command": "php",
      "args": [
        "/absolute/path/to/praesepe-ui/artisan",
        "mcp:start",
        "praesepe-ui"
      ]
    }
  }
}</code></pre>

    <h2 id="tools" class="mt-10 text-xl font-semibold tracking-tight text-fg">Tools</h2>
    <div class="mt-4 overflow-x-auto rounded-card border border-border bg-surface-raised shadow-2xs">
        <table class="w-full min-w-[28rem] text-left text-sm">
            <thead class="border-b border-border bg-surface-sunken text-xs font-semibold uppercase tracking-wide text-fg-muted">
                <tr>
                    <th class="px-4 py-3">Tool</th>
                    <th class="px-4 py-3">Purpose</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border text-fg">
                <tr>
                    <td class="px-4 py-3 font-mono text-xs tabular-nums">list_components</td>
                    <td class="px-4 py-3 text-fg-muted">List components (optional category)</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-mono text-xs tabular-nums">search_components</td>
                    <td class="px-4 py-3 text-fg-muted">Search by name, slug, tags, or props</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-mono text-xs tabular-nums">get_component</td>
                    <td class="px-4 py-3 text-fg-muted">Props, a11y notes, example slugs</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-mono text-xs tabular-nums">get_snippet</td>
                    <td class="px-4 py-3 text-fg-muted">Blade or HTML source for an example</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-mono text-xs tabular-nums">list_icons</td>
                    <td class="px-4 py-3 text-fg-muted">Built-in <code class="rounded bg-surface-sunken px-1">x-icons.*</code> set</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-mono text-xs tabular-nums">get_guidelines</td>
                    <td class="px-4 py-3 text-fg-muted">Authoring rules for agents (same as resource below)</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="mt-4 text-sm text-fg-muted leading-relaxed">
        Resource
        <code class="rounded bg-surface-sunken px-1 text-sm tabular-nums">praesepe://guidelines</code>
        exposes the same authoring rules (including Anti-generic and Taste rules) for clients that prefer MCP resources over tools.
    </p>

    <h2 id="workflow" class="mt-10 text-xl font-semibold tracking-tight text-fg">Agent workflow</h2>
    <ol class="mt-3 list-decimal space-y-2 pl-5 text-fg leading-relaxed">
        <li><code class="rounded bg-surface-sunken px-1 text-sm">get_guidelines</code> or resource <code class="rounded bg-surface-sunken px-1 text-sm">praesepe://guidelines</code> once per task</li>
        <li><code class="rounded bg-surface-sunken px-1 text-sm">search_components</code> or <code class="rounded bg-surface-sunken px-1 text-sm">list_components</code></li>
        <li><code class="rounded bg-surface-sunken px-1 text-sm">get_component</code> for props and example slugs</li>
        <li><code class="rounded bg-surface-sunken px-1 text-sm">get_snippet</code> with <code class="rounded bg-surface-sunken px-1 text-sm">blade</code> or <code class="rounded bg-surface-sunken px-1 text-sm">html</code></li>
        <li>Adapt the snippet. Keep Alpine long-form (<code class="rounded bg-surface-sunken px-1 text-sm">x-on:click</code>, <code class="rounded bg-surface-sunken px-1 text-sm">x-bind:class</code>) in Blade</li>
    </ol>
    <p class="mt-6 text-sm text-fg-muted leading-relaxed">
        More detail for maintainers:
        <code class="rounded bg-surface-sunken px-1 text-sm">mcp/README.md</code>
        in the repository.
    </p>
</article>
@endsection
