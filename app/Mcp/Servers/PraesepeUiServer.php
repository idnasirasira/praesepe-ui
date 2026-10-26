<?php

declare(strict_types=1);

namespace App\Mcp\Servers;

use App\Mcp\Resources\AuthoringGuidelines;
use App\Mcp\Tools\GetComponentTool;
use App\Mcp\Tools\GetGuidelinesTool;
use App\Mcp\Tools\GetSnippetTool;
use App\Mcp\Tools\ListComponentsTool;
use App\Mcp\Tools\ListIconsTool;
use App\Mcp\Tools\SearchComponentsTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Resource;
use Laravel\Mcp\Server\Tool;

#[Name('praesepe-ui')]
#[Version('0.1.0')]
#[Instructions('Praesepe UI component library MCP. Always read praesepe://guidelines or get_guidelines first (Anti-generic + Taste rules). Then search/list components, get_component for props/a11y, get_snippet for Blade or HTML. Prefer Blade. Keep Alpine long-form. Never ship purple-gradient, glow, or invented metrics.')]
class PraesepeUiServer extends Server
{
    /**
     * @var array<int, class-string<Tool>>
     */
    protected array $tools = [
        ListComponentsTool::class,
        SearchComponentsTool::class,
        GetComponentTool::class,
        GetSnippetTool::class,
        ListIconsTool::class,
        GetGuidelinesTool::class,
    ];

    /**
     * @var array<int, class-string<resource>>
     */
    protected array $resources = [
        AuthoringGuidelines::class,
    ];

    /**
     * @var array<int, class-string<Prompt>>
     */
    protected array $prompts = [];
}
