<?php

declare(strict_types=1);

namespace App\Mcp\Resources;

use App\Docs\AgentGuidelines;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\MimeType;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Uri;
use Laravel\Mcp\Server\Resource;

#[Name('authoring-guidelines')]
#[Uri('praesepe://guidelines')]
#[MimeType('text/markdown')]
#[Description('Praesepe UI authoring rules for agents: Anti-generic, Taste rules, Blade, Alpine, tokens, forms, overlays, icons, and copy-paste workflow.')]
class AuthoringGuidelines extends Resource
{
    public function handle(Request $request): Response
    {
        return Response::text(AgentGuidelines::text());
    }
}
