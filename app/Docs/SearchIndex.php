<?php

declare(strict_types=1);

namespace App\Docs;

use Illuminate\Support\Facades\Cache;

class SearchIndex
{
    public function __construct(
        private readonly ComponentRegistry $registry,
    ) {}

    /**
     * @return list<array{type: string, title: string, description: string, href: string, tags: list<string>}>
     */
    public function all(): array
    {
        if (app()->isLocal()) {
            return $this->build();
        }

        /** @var list<array{type: string, title: string, description: string, href: string, tags: list<string>}> $cached */
        $cached = Cache::rememberForever('ui.search-index', fn (): array => $this->build());

        return $cached;
    }

    /**
     * @return list<array{type: string, title: string, description: string, href: string, tags: list<string>}>
     */
    private function build(): array
    {
        $entries = [
            [
                'type' => 'page',
                'title' => 'Installation',
                'description' => 'Install Praesepe UI with Tailwind CSS 4 and Alpine.js 3.',
                'href' => route('docs.index', absolute: false),
                'tags' => ['install', 'setup', 'tailwind', 'alpine'],
            ],
            [
                'type' => 'page',
                'title' => 'Theming',
                'description' => 'Semantic CSS tokens, themes, and dark mode.',
                'href' => route('docs.theming', absolute: false),
                'tags' => ['theme', 'dark mode', 'tokens'],
            ],
            [
                'type' => 'page',
                'title' => 'Accessibility',
                'description' => 'Keyboard and ARIA patterns used across components.',
                'href' => route('docs.accessibility', absolute: false),
                'tags' => ['a11y', 'keyboard', 'aria'],
            ],
            [
                'type' => 'page',
                'title' => 'Themes gallery',
                'description' => 'Preview praesepe, minimal, and warm themes.',
                'href' => route('themes.index', absolute: false),
                'tags' => ['themes', 'gallery'],
            ],
            [
                'type' => 'page',
                'title' => 'Kitchen sink',
                'description' => 'Live playground of every registered component.',
                'href' => route('ui.index', absolute: false),
                'tags' => ['kitchen sink', 'preview'],
            ],
        ];

        foreach ($this->registry->all() as $component) {
            $entries[] = [
                'type' => 'component',
                'title' => $component->name,
                'description' => $component->description,
                'href' => route('docs.components.show', $component->slug, absolute: false),
                'tags' => array_values(array_unique(array_merge(
                    [$component->category, $component->slug],
                    $component->tags,
                ))),
            ];
        }

        return $entries;
    }
}
