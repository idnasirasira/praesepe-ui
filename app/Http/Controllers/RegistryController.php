<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Docs\InstallRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;

class RegistryController extends Controller
{
    public function index(InstallRegistry $registry): JsonResponse
    {
        return response()->json($registry->index());
    }

    public function show(string $slug, InstallRegistry $registry): JsonResponse
    {
        try {
            $package = $registry->package($slug);
        } catch (InvalidArgumentException $exception) {
            abort(404, $exception->getMessage());
        }

        return response()->json($package);
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
        return response()->json([
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
}
