<?php

declare(strict_types=1);

use App\Mcp\Resources\AuthoringGuidelines;
use App\Mcp\Servers\PraesepeUiServer;
use App\Mcp\Tools\GetComponentTool;
use App\Mcp\Tools\GetGuidelinesTool;
use App\Mcp\Tools\GetSnippetTool;
use App\Mcp\Tools\ListComponentsTool;
use App\Mcp\Tools\ListIconsTool;
use App\Mcp\Tools\SearchComponentsTool;

it('lists praesepe ui components over mcp', function (): void {
    $response = PraesepeUiServer::tool(ListComponentsTool::class, []);

    $response
        ->assertOk()
        ->assertSee('"slug": "button"')
        ->assertSee('"count":');
});

it('searches components by query', function (): void {
    $response = PraesepeUiServer::tool(SearchComponentsTool::class, [
        'query' => 'navbar',
    ]);

    $response
        ->assertOk()
        ->assertSee('"slug": "navbar"');
});

it('returns component details and snippets', function (): void {
    $component = PraesepeUiServer::tool(GetComponentTool::class, [
        'slug' => 'button',
    ]);

    $component
        ->assertOk()
        ->assertSee('"name": "Button"')
        ->assertSee('"props"');

    $snippet = PraesepeUiServer::tool(GetSnippetTool::class, [
        'slug' => 'button',
        'example' => 'variants',
        'format' => 'blade',
    ]);

    $snippet
        ->assertOk()
        ->assertSee('x-ui.button')
        ->assertSee('"format": "blade"');
});

it('lists icons and guidelines', function (): void {
    PraesepeUiServer::tool(ListIconsTool::class, [])
        ->assertOk()
        ->assertSee('"name": "search"')
        ->assertSee('x-icons.');

    PraesepeUiServer::tool(GetGuidelinesTool::class, [])
        ->assertOk()
        ->assertSee('Anti-generic')
        ->assertSee('Taste rules')
        ->assertSee('long-form')
        ->assertSee('get_snippet')
        ->assertSee('/docs/mcp')
        ->assertSee('https://ui.praesepe.id/mcp/praesepe-ui')
        ->assertSee('Theme tokens')
        ->assertSee('tabular-nums')
        ->assertSee('praesepe://guidelines');
});

it('exposes authoring guidelines as an mcp resource', function (): void {
    PraesepeUiServer::resource(AuthoringGuidelines::class)
        ->assertOk()
        ->assertSee('Anti-generic')
        ->assertSee('Ban list')
        ->assertSee('Taste rules')
        ->assertSee('x-teleport')
        ->assertSee('Heroicons');
});

it('errors on unknown component slug', function (): void {
    PraesepeUiServer::tool(GetComponentTool::class, [
        'slug' => 'does-not-exist',
    ])->assertHasErrors([
        'Unknown component slug: does-not-exist',
    ]);
});

it('exposes a public http mcp endpoint', function (): void {
    $this->get('/mcp/praesepe-ui')
        ->assertStatus(405)
        ->assertHeader('Allow', 'POST');
});

it('renders the mcp consumer docs page', function (): void {
    $this->get('/docs/mcp')
        ->assertOk()
        ->assertSee('MCP for agents', false)
        ->assertSee('https://ui.praesepe.id/mcp/praesepe-ui', false)
        ->assertSee('get_guidelines', false)
        ->assertSee('Remote HTTP', false)
        ->assertSee('Agent prompt', false)
        ->assertSee('Copy user rule', false)
        ->assertSee('When building Laravel Blade + Tailwind + Alpine UI with Praesepe UI', false);
});
