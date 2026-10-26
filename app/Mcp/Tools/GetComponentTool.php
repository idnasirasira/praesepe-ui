<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\ComponentRegistry;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_component')]
#[Description('Return props API, accessibility notes, tags, and example slugs for one Praesepe UI component.')]
class GetComponentTool extends Tool
{
    public function __construct(
        private readonly ComponentRegistry $registry,
    ) {}

    public function handle(Request $request): Response
    {
        $slug = $request->string('slug')->toString();
        $page = $this->registry->find($slug);

        if ($page === null) {
            return Response::error("Unknown component slug: {$slug}");
        }

        return Response::text((string) json_encode($page->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'slug' => $schema->string()
                ->description('Component slug, e.g. button, navbar, modal')
                ->required(),
        ];
    }
}
