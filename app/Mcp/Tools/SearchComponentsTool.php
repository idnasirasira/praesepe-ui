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

#[Name('search_components')]
#[Description('Full-text search across Praesepe UI component names, slugs, descriptions, tags, and prop names.')]
class SearchComponentsTool extends Tool
{
    public function __construct(
        private readonly ComponentRegistry $registry,
    ) {}

    public function handle(Request $request): Response
    {
        $query = strtolower($request->string('query')->toString());
        $category = $request->string('category')->toString();
        $category = $category !== '' ? strtolower($category) : null;

        $components = collect($this->registry->all())
            ->when(
                $category !== null,
                fn ($items) => $items->filter(
                    static fn (ComponentPage $page): bool => strtolower($page->category) === $category,
                ),
            )
            ->filter(function (ComponentPage $page) use ($query): bool {
                if ($query === '') {
                    return true;
                }

                $propNames = collect($page->props)
                    ->map(static fn (array $prop): string => (string) ($prop['name'] ?? ''))
                    ->implode(' ');

                $haystack = strtolower(implode(' ', [
                    $page->slug,
                    $page->name,
                    $page->description,
                    $page->category,
                    implode(' ', $page->tags),
                    $propNames,
                ]));

                return str_contains($haystack, $query);
            })
            ->map(static fn (ComponentPage $page): array => [
                'slug' => $page->slug,
                'name' => $page->name,
                'category' => $page->category,
                'tags' => $page->tags,
                'description' => $page->description,
            ])
            ->values()
            ->all();

        return Response::text((string) json_encode([
            'query' => $query,
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
            'query' => $schema->string()
                ->description('Search query, e.g. navbar, toast, password')
                ->required(),
            'category' => $schema->string()
                ->description('Optional category filter'),
        ];
    }
}
