<?php

declare(strict_types=1);

use App\Docs\IconCatalog;

it('lists icon blade components from the icons directory', function (): void {
    $icons = app(IconCatalog::class)->all();

    expect($icons)->not->toBeEmpty()
        ->and(collect($icons)->pluck('name'))->toContain('search', 'check', 'praesepe');
});

it('renders the icons docs page with gallery and bring-your-own guidance', function (): void {
    $response = $this->get('/docs/icons');

    $response->assertOk()
        ->assertSee('Icons', false)
        ->assertSee('Bring your own', false)
        ->assertSee('Heroicons', false)
        ->assertSee('x-icons.search', false)
        ->assertSee('leadingIcon', false);
});
