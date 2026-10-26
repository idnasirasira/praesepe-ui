<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\ComponentPage;
use App\Docs\ComponentRegistry;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('list_components')]
#[Description('List registered Praesepe UI components with slug, name, category, tags, and description. Optionally filter by category.')]
class ListComponentsTool extends Tool
{
    public function __construct(
        private readonly ComponentRegistry $registry,
    ) {}

    public function handle(Request $request): Response
    {
        $category = $request->string('category')->toString();
        $category = $category !== '' ? strtolower($category) : null;

        $components = collect($this->registry->all())
            ->when(
                $category !== null,
                fn ($items) => $items->filter(
                    static fn (ComponentPage $page): bool => strtolower($page->category) === $category,
                ),
            )
            ->map(static fn (ComponentPage $page): array => [
                'slug' => $page->slug,
                'name' => $page->name,
                'category' => $page->category,
                'tags' => $page->tags,
                'description' => $page->description,
                'examples' => collect($page->examples)->pluck('slug')->values()->all(),
            ])
            ->values()
            ->all();

        return Response::text((string) json_encode([
            'count' => count($components),
            'components' => $components,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'category' => $schema->string()
                ->description('Optional category filter, e.g. actions, forms, overlays, layout, data-display'),
        ];
    }
}
