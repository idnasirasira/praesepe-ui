<?php

declare(strict_types=1);

use App\Docs\ComponentRegistry;
use App\Docs\SnippetRepository;

it('keeps html snippets free of blade syntax', function (): void {
    $registry = app(ComponentRegistry::class);
    $snippets = app(SnippetRepository::class);

    foreach ($registry->all() as $page) {
        foreach ($page->examples as $example) {
            $html = $snippets->raw($page->slug, $example['slug'], 'html');

            expect($html)->not->toContain('{{')
                ->and($html)->not->toContain('@props')
                ->and($html)->not->toContain('<x-');
        }
    }
});

it('keeps blade snippets free of alpine shorthand directives', function (): void {
    $registry = app(ComponentRegistry::class);
    $snippets = app(SnippetRepository::class);

    foreach ($registry->all() as $page) {
        foreach ($page->examples as $example) {
            $blade = $snippets->raw($page->slug, $example['slug'], 'blade.php');

            expect($blade)->not->toContain(':class=')
                ->and($blade)->not->toContain('@click=');
        }
    }
});
