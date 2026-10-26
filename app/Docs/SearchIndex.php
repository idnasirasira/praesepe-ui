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
     * @return list<array{
     *     type: string,
     *     title: string,
     *     description: string,
     *     href: string,
     *     tags: list<string>,
     *     props: list<string>,
     *     variants: list<string>,
     *     headings: list<string>
     * }>
     */
    public function all(): array
    {
        if (app()->isLocal()) {
            return $this->build();
        }

        /** @var list<array{
         *     type: string,
         *     title: string,
         *     description: string,
         *     href: string,
         *     tags: list<string>,
         *     props: list<string>,
         *     variants: list<string>,
         *     headings: list<string>
         * }> $cached */
        $cached = Cache::rememberForever('ui.search-index', fn (): array => $this->build());

        return $cached;
    }

    /**
     * @return list<array{
     *     type: string,
     *     title: string,
     *     description: string,
     *     href: string,
     *     tags: list<string>,
     *     props: list<string>,
     *     variants: list<string>,
     *     headings: list<string>
     * }>
     */
    private function build(): array
    {
        $entries = [
            $this->page(
                title: 'Installation',
                description: 'Install Praesepe UI with Tailwind CSS 4 and Alpine.js 3.',
                href: route('docs.index', absolute: false),
                tags: ['install', 'setup', 'tailwind', 'alpine'],
                headings: ['Quick start', 'Stack', 'Copy a component'],
            ),
            $this->page(
                title: 'Theming',
                description: 'Semantic CSS tokens, themes, and dark mode.',
                href: route('docs.theming', absolute: false),
                tags: ['theme', 'dark mode', 'tokens'],
                headings: ['Built-in themes', 'Semantic tokens', 'Runtime dark mode'],
            ),
            $this->page(
                title: 'Icons',
                description: 'Built-in operational icons and bring-your-own guidance for Heroicons or any SVG.',
                href: route('docs.icons', absolute: false),
                tags: ['icons', 'svg', 'heroicons', 'slots'],
                headings: ['Built-in set', 'Usage', 'Bring your own', 'Accessibility'],
            ),
            $this->page(
                title: 'Accessibility',
                description: 'Keyboard and ARIA patterns used across components.',
                href: route('docs.accessibility', absolute: false),
                tags: ['a11y', 'keyboard', 'aria'],
                headings: ['Shared conventions', 'Automated coverage', 'Manual screen reader checks'],
            ),
            $this->page(
                title: 'Themes gallery',
                description: 'Preview praesepe, minimal, and warm themes.',
                href: route('themes.index', absolute: false),
                tags: ['themes', 'gallery'],
                headings: ['Praesepe', 'Minimal', 'Warm'],
            ),
            $this->page(
                title: 'Kitchen sink',
                description: 'Live playground of every registered component.',
                href: route('ui.index', absolute: false),
                tags: ['kitchen sink', 'preview'],
                headings: ['Live previews'],
            ),
            $this->page(
                title: 'Components index',
                description: 'Browse every registered Praesepe UI component.',
                href: route('docs.components.index', absolute: false),
                tags: ['components', 'library'],
                headings: ['All components'],
            ),
        ];

        foreach ($this->registry->all() as $component) {
            $propNames = [];

            foreach ($component->props as $prop) {
                if (isset($prop['name']) && is_string($prop['name'])) {
                    $propNames[] = $prop['name'];
                }
            }

            $variants = [];

            foreach ($component->examples as $example) {
                if (isset($example['slug']) && is_string($example['slug'])) {
                    $variants[] = $example['slug'];
                }

                if (isset($example['title']) && is_string($example['title'])) {
                    $variants[] = $example['title'];
                }
            }

            $entries[] = [
                'type' => 'component',
                'title' => $component->name,
                'description' => $component->description,
                'href' => route('docs.components.show', $component->slug, absolute: false),
                'tags' => array_values(array_unique(array_merge(
                    [$component->category, $component->slug],
                    $component->tags,
                ))),
                'props' => array_values(array_unique($propNames)),
                'variants' => array_values(array_unique($variants)),
                'headings' => array_values(array_unique(array_filter([
                    $component->name,
                    $component->category,
                    'Props',
                    'Accessibility',
                    'Examples',
                ]))),
            ];
        }

        return $entries;
    }

    /**
     * @param  list<string>  $tags
     * @param  list<string>  $headings
     * @return array{
     *     type: string,
     *     title: string,
     *     description: string,
     *     href: string,
     *     tags: list<string>,
     *     props: list<string>,
     *     variants: list<string>,
     *     headings: list<string>
     * }
     */
    private function page(
        string $title,
        string $description,
        string $href,
        array $tags,
        array $headings,
    ): array {
        return [
            'type' => 'page',
            'title' => $title,
            'description' => $description,
            'href' => $href,
            'tags' => $tags,
            'props' => [],
            'variants' => [],
            'headings' => $headings,
        ];
    }
}
