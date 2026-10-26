<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\AgentGuidelines;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_guidelines')]
#[Description('Return Praesepe UI authoring rules including Anti-generic and Taste rules, plus Blade/Alpine/token rules. Same content as resource praesepe://guidelines. Call this before writing UI.')]
class GetGuidelinesTool extends Tool
{
    public function handle(Request $request): Response
    {
        return Response::text(AgentGuidelines::text());
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
