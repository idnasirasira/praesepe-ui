<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Docs\InstallRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class RegistryController extends Controller
{
    public function home(InstallRegistry $registry): View
    {
        $index = $registry->index();

        return view('registry.index', [
            'version' => $index['version'],
            'registry' => $index['registry'],
            'items' => $index['items'],
            'cliPackage' => (string) config('ui-docs.cli_package'),
            'mcpUrl' => (string) config('ui-docs.mcp_url'),
            'cliPublished' => (bool) config('ui-docs.cli_published', false),
        ]);
    }

    public function index(InstallRegistry $registry): JsonResponse
    {
        return $this->cachedJson($registry->index());
    }

    public function show(string $slug, InstallRegistry $registry): JsonResponse
    {
        try {
            $package = $registry->package($slug);
        } catch (InvalidArgumentException|RuntimeException $exception) {
            abort(404, $exception->getMessage());
        } catch (Throwable $exception) {
            report($exception);
            abort(404, 'Install package unavailable for slug: '.$slug);
        }

        return $this->cachedJson($package);
    }

    public function theme(InstallRegistry $registry): Response
    {
        return response($registry->themeCss(), 200, [
            'Content-Type' => 'text/css; charset=UTF-8',
            'Cache-Control' => 'public, max-age=300',
        ]);
    }

    public function schema(): JsonResponse
    {
        return $this->cachedJson([
            '$schema' => 'https://json-schema.org/draft/2020-12/schema',
            '$id' => rtrim((string) config('ui-docs.registry_url'), '/').'/schema.json',
            'title' => 'Praesepe UI components.json',
            'type' => 'object',
            'required' => ['style', 'registry', 'aliases'],
            'properties' => [
                'style' => ['type' => 'string'],
                'registry' => ['type' => 'string', 'format' => 'uri'],
                'aliases' => [
                    'type' => 'object',
                    'required' => ['ui', 'icons', 'css'],
                    'properties' => [
                        'ui' => ['type' => 'string'],
                        'icons' => ['type' => 'string'],
                        'css' => ['type' => 'string'],
                    ],
                ],
            ],
            'additionalProperties' => true,
        ]);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function cachedJson(array $payload): JsonResponse
    {
        return response()
            ->json($payload)
            ->header('Cache-Control', 'public, max-age=60');
    }
}
