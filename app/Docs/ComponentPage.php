<?php

declare(strict_types=1);

namespace App\Docs;

readonly class ComponentPage
{
    /**
     * @param  list<array{name: string, type: string, default: string|null, description: string}>  $props
     * @param  list<string>  $a11yNotes
     * @param  list<array{slug: string, title: string, description?: string}>  $examples
     * @param  list<string>  $tags
     */
    public function __construct(
        public string $slug,
        public string $name,
        public string $description,
        public string $category,
        public array $props = [],
        public array $a11yNotes = [],
        public array $examples = [],
        public array $tags = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            slug: (string) $data['slug'],
            name: (string) $data['name'],
            description: (string) $data['description'],
            category: (string) ($data['category'] ?? 'general'),
            props: $data['props'] ?? [],
            a11yNotes: $data['a11yNotes'] ?? $data['a11y'] ?? [],
            examples: $data['examples'] ?? [],
            tags: $data['tags'] ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'props' => $this->props,
            'a11yNotes' => $this->a11yNotes,
            'examples' => $this->examples,
            'tags' => $this->tags,
        ];
    }
}
