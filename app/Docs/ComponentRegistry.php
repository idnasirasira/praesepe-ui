<?php

declare(strict_types=1);

namespace App\Docs;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use RuntimeException;

class ComponentRegistry
{
    public function __construct(
        private readonly SnippetRepository $snippets,
        private readonly string $docsPath = '',
    ) {}

    private function docsPath(): string
    {
        return $this->docsPath !== '' ? $this->docsPath : resource_path('docs/components');
    }

    /**
     * @return list<ComponentPage>
     */
    public function all(): array
    {
        if (app()->isLocal()) {
            return $this->build();
        }

        /** @var list<array<string, mixed>> $cached */
        $cached = Cache::rememberForever('ui.registry', fn (): array => array_map(
            static fn (ComponentPage $page): array => $page->toArray(),
            $this->build(),
        ));

        return array_map(
            static fn (array $data): ComponentPage => ComponentPage::fromArray($data),
            $cached,
        );
    }

    public function find(string $slug): ?ComponentPage
    {
        foreach ($this->all() as $page) {
            if ($page->slug === $slug) {
                return $page;
            }
        }

        return null;
    }

    public function findOrFail(string $slug): ComponentPage
    {
        $page = $this->find($slug);

        if ($page === null) {
            throw new RuntimeException("Unknown component: {$slug}");
        }

        return $page;
    }

    /**
     * @return list<array{slug: string, title: string, description?: string, html: string, blade: string, preview: string}>
     */
    public function examplesFor(ComponentPage $page): array
    {
        $loaded = [];

        foreach ($page->examples as $example) {
            $snippet = $this->snippets->loadExample($page->slug, $example['slug']);
            $loaded[] = [
                'slug' => $example['slug'],
                'title' => $example['title'],
                'description' => $example['description'] ?? '',
                'html' => $snippet['html'],
                'blade' => $snippet['blade'],
                'preview' => $snippet['preview'],
            ];
        }

        return $loaded;
    }

    /**
     * @return list<ComponentPage>
     */
    private function build(): array
    {
        $path = $this->docsPath();

        if (! File::isDirectory($path)) {
            return [];
        }

        $pages = [];

        foreach (File::files($path) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            /** @var array<string, mixed> $data */
            $data = require $file->getPathname();

            if (! isset($data['slug'], $data['name'], $data['description'])) {
                throw new RuntimeException('Invalid component metadata: '.$file->getFilename());
            }

            $pages[] = ComponentPage::fromArray($data);
        }

        usort(
            $pages,
            static fn (ComponentPage $a, ComponentPage $b): int => strcmp($a->name, $b->name),
        );

        return $pages;
    }
}
