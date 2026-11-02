<?php

declare(strict_types=1);

use App\Docs\ComponentRegistry;

it('serves a human registry landing page', function (): void {
    $this->get('/r')
        ->assertOk()
        ->assertSee('Praesepe UI registry', false)
        ->assertSee('/r/index.json', false)
        ->assertSee('button', false);
});

it('serves the registry index json', function (): void {
    $response = $this->getJson('/r/index.json');

    $response->assertOk()
        ->assertJsonStructure([
            'version',
            'registry',
            'items' => [
                ['slug', 'name', 'description', 'category'],
            ],
        ]);

    expect($response->json('items'))->not->toBeEmpty()
        ->and(collect($response->json('items'))->pluck('slug'))->toContain('button')
        ->and($response->headers->get('Cache-Control'))->toContain('max-age=60')
        ->and($response->headers->get('Cache-Control'))->toContain('public');
});

it('serves a component registry package with file contents', function (): void {
    $response = $this->getJson('/r/button.json');

    $response->assertOk()
        ->assertJsonPath('slug', 'button')
        ->assertJsonStructure([
            'slug',
            'name',
            'description',
            'dependencies',
            'icons',
            'files' => [
                ['path', 'type', 'content', 'dependency_of'],
            ],
        ]);

    $paths = collect($response->json('files'))->pluck('path');

    expect($paths)->toContain('resources/views/components/ui/button.blade.php')
        ->and($paths)->toContain('resources/views/components/icons/spinner.blade.php')
        ->and($response->json('files.0.content'))->not->toBeEmpty();
});

it('returns 404 for unknown registry slugs', function (): void {
    $this->getJson('/r/does-not-exist.json')->assertNotFound();
});

it('serves theme.css for cli init', function (): void {
    $response = $this->get('/r/styles/theme.css');

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('text/css')
        ->and($response->getContent())->toContain('--ui-');
});

it('serves components.json schema', function (): void {
    $this->getJson('/r/schema.json')
        ->assertOk()
        ->assertJsonPath('title', 'Praesepe UI components.json');
});

it('serves a package for every registered component slug', function (): void {
    foreach (app(ComponentRegistry::class)->all() as $page) {
        $this->getJson('/r/'.$page->slug.'.json')
            ->assertOk()
            ->assertJsonPath('slug', $page->slug);
    }
});

it('maps toast to toast-viewport install files', function (): void {
    $response = $this->getJson('/r/toast.json');

    $response->assertOk();

    $paths = collect($response->json('files'))->pluck('path');

    expect($paths)->toContain('resources/views/components/ui/toast-viewport.blade.php');
});
