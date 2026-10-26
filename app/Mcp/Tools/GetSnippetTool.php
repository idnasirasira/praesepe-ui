<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Docs\ComponentRegistry;
use App\Docs\SnippetRepository;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use InvalidArgumentException;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_snippet')]
#[Description('Return the Blade or HTML+Alpine snippet for a Praesepe UI component example. Prefer Blade for Laravel apps; use HTML for plain Alpine copy-paste.')]
class GetSnippetTool extends Tool
{
    public function __construct(
        private readonly ComponentRegistry $registry,
        private readonly SnippetRepository $snippets,
    ) {}

    public function handle(Request $request): Response
    {
        $slug = $request->string('slug')->toString();
        $example = $request->string('example')->toString();
        $format = $request->get('format', 'blade');
        $format = is_string($format) && $format !== '' ? $format : 'blade';

        if (! in_array($format, ['blade', 'html'], true)) {
            return Response::error('format must be blade or html');
        }

        $page = $this->registry->find($slug);

        if ($page === null) {
            return Response::error("Unknown component slug: {$slug}");
        }

        $meta = collect($page->examples)->firstWhere('slug', $example);

        if ($meta === null) {
            return Response::error("Unknown example [{$example}] for component [{$slug}]");
        }

        $extension = $format === 'html' ? 'html' : 'blade.php';

        try {
            $source = $this->snippets->raw($slug, $example, $extension);
        } catch (InvalidArgumentException $exception) {
            return Response::error($exception->getMessage());
        }

        return Response::text((string) json_encode([
            'slug' => $slug,
            'example' => $example,
            'format' => $format,
            'title' => $meta['title'] ?? $example,
            'description' => $meta['description'] ?? '',
            'path' => "resources/snippets/{$slug}/{$example}.{$extension}",
            'source' => $source,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'slug' => $schema->string()
                ->description('Component slug, e.g. button')
                ->required(),
            'example' => $schema->string()
                ->description('Example slug from get_component, e.g. variants')
                ->required(),
            'format' => $schema->string()
                ->enum(['blade', 'html'])
                ->description('Snippet format: blade or html')
                ->default('blade'),
        ];
    }
}
