<?php

declare(strict_types=1);

use App\Docs\ComponentRegistry;
use App\Docs\SnippetRepository;

it('validates metadata schema for every registered component', function (): void {
    $registry = app(ComponentRegistry::class);

    expect($registry->all())->not->toBeEmpty();

    foreach ($registry->all() as $page) {
        expect($page->slug)->toMatch('/^[a-z0-9-]+$/')
            ->and($page->name)->not->toBeEmpty()
            ->and($page->description)->not->toBeEmpty()
            ->and($page->category)->not->toBeEmpty()
            ->and($page->examples)->not->toBeEmpty();

        foreach ($page->props as $prop) {
            expect($prop)->toHaveKeys(['name', 'type', 'default', 'description']);
        }

        foreach ($page->examples as $example) {
            expect($example)->toHaveKeys(['slug', 'title']);
        }
    }
});

it('ensures every registered example has html and blade snippets that render', function (): void {
    $registry = app(ComponentRegistry::class);
    $snippets = app(SnippetRepository::class);

    foreach ($registry->all() as $page) {
        foreach ($page->examples as $example) {
            expect($snippets->exists($page->slug, $example['slug'], 'html'))->toBeTrue()
                ->and($snippets->exists($page->slug, $example['slug'], 'blade.php'))->toBeTrue();

            $loaded = $snippets->loadExample($page->slug, $example['slug']);

            expect($loaded['html'])->not->toBeEmpty()
                ->and($loaded['blade'])->not->toBeEmpty()
                ->and($loaded['preview'])->not->toBeEmpty();
        }
    }
});
