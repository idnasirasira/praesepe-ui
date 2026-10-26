<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\IconCatalog;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('list_icons')]
#[Description('List built-in operational icons as x-icons.* Blade components. Consumers may also bring Heroicons or any SVG via slots.')]
class ListIconsTool extends Tool
{
    public function __construct(
        private readonly IconCatalog $icons,
    ) {}

    public function handle(Request $request): Response
    {
        $icons = $this->icons->all();

        return Response::text((string) json_encode([
            'count' => count($icons),
            'note' => 'Praesepe does not ship an icon package dependency. Use these operational icons or paste Heroicons/Lucide/custom SVG into slots.',
            'icons' => $icons,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
