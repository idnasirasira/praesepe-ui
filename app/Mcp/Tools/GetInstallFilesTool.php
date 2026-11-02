<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\InstallRegistry;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use InvalidArgumentException;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_install_files')]
#[Description('Return Blade primitive and icon file payloads to write into a Laravel app. Resolves component dependencies. Call this before using x-ui.* tags. Prefer after get_component; use get_snippet for usage examples.')]
class GetInstallFilesTool extends Tool
{
    public function __construct(
        private readonly InstallRegistry $install,
    ) {}

    public function handle(Request $request): Response
    {
        $slugs = $request->get('slugs', []);

        if (is_string($slugs)) {
            $slugs = preg_split('/[\s,]+/', $slugs) ?: [];
        }

        if (! is_array($slugs)) {
            return Response::error('slugs must be an array of component slugs');
        }

        /** @var list<string> $normalized */
        $normalized = array_values(array_filter(
            array_map(static fn (mixed $slug): string => is_string($slug) ? trim($slug) : '', $slugs),
            static fn (string $slug): bool => $slug !== '',
        ));

        try {
            $payload = $this->install->resolve($normalized);
        } catch (InvalidArgumentException $exception) {
            return Response::error($exception->getMessage());
        }

        return Response::text((string) json_encode([
            ...$payload,
            'instructions' => [
                'Write each files[].path with files[].content into the consumer Laravel project (create directories as needed).',
                'Do not invent props. Call get_component and get_snippet for API and usage examples after files are written.',
                'Ensure theme.css and Alpine focus are installed (get_init_files or npx @praesepe/ui init).',
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'slugs' => $schema->array()
                ->items($schema->string()->description('Component slug, e.g. button'))
                ->description('One or more component slugs to install, e.g. ["modal","button"]')
                ->required(),
        ];
    }
}
