<?php

declare(strict_types=1);

use App\Docs\ComponentRegistry;

it('returns 200 for all public docs routes', function (string $uri): void {
    $response = $this->get($uri);

    $response->assertOk();
})->with([
    '/',
    '/docs',
    '/docs/theming',
    '/docs/accessibility',
    '/docs/icons',
    '/docs/components',
    '/ui',
    '/themes',
    '/search-index.json',
    '/sitemap.xml',
    '/robots.txt',
]);

it('returns 404 for an unknown component slug', function (): void {
    $this->get('/docs/components/does-not-exist')->assertNotFound();
});

it('renders each registered component page', function (): void {
    $registry = app(ComponentRegistry::class);

    foreach ($registry->all() as $component) {
        $this->get('/docs/components/'.$component->slug)->assertOk();
    }

    expect($registry->all())->not->toBeEmpty();
});

it('includes exactly one h1 and valid meta tags on html pages', function (string $uri): void {
    $response = $this->get($uri);

    $response->assertOk();

    $html = $response->getContent();

    expect(preg_match_all('/<h1\b/i', $html))->toBe(1)
        ->and($html)->toContain('<meta name="description"')
        ->and($html)->toContain('<title>');
})->with([
    '/',
    '/docs',
    '/docs/theming',
    '/docs/accessibility',
    '/docs/icons',
    '/docs/components',
    '/ui',
    '/themes',
]);
