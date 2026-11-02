<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\InstallRegistry;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_init_files')]
#[Description('Return theme.css content and a setup checklist for wiring Praesepe UI into a Laravel + Tailwind v4 + Alpine app. Call once per project before get_install_files.')]
class GetInitFilesTool extends Tool
{
    public function __construct(
        private readonly InstallRegistry $install,
    ) {}

    public function handle(Request $request): Response
    {
        $init = $this->install->init();
        $registryUrl = (string) config('ui-docs.registry_url');
        $cli = (string) config('ui-docs.cli_package');

        return Response::text((string) json_encode([
            'files' => [
                [
                    'path' => $init['path'],
                    'content' => $init['content'],
                    'type' => 'style',
                ],
            ],
            'app_css' => [
                'import' => '@import "./theme.css";',
                'sources' => [
                    '@source "../views/**/*.blade.php";',
                ],
                'note' => 'Place the import beside @import "tailwindcss"; and keep @source pointing at Blade that uses Praesepe components.',
            ],
            'alpine' => [
                'packages' => ['alpinejs', '@alpinejs/focus'],
                'example' => <<<'JS'
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);
window.Alpine = Alpine;
Alpine.start();
JS,
            ],
            'checklist' => $init['checklist'],
            'cli' => [
                'init' => "npx {$cli}@latest init",
                'add' => "npx {$cli}@latest add button",
                'registry' => $registryUrl,
            ],
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
