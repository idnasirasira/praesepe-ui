<?php

declare(strict_types=1);

it('exposes searchable props variants and headings in the search index', function (): void {
    $response = $this->getJson('/search-index.json');

    $response->assertOk()
        ->assertJsonStructure([
            'version',
            'entries' => [
                '*' => [
                    'type',
                    'title',
                    'description',
                    'href',
                    'tags',
                    'props',
                    'variants',
                    'headings',
                ],
            ],
        ]);

    $entries = $response->json('entries');
    $button = collect($entries)->firstWhere('title', 'Button');

    expect($button)->not->toBeNull()
        ->and($button['props'])->toBeArray()
        ->and($button['variants'])->not->toBeEmpty()
        ->and($button['headings'])->toContain('Props');
});
