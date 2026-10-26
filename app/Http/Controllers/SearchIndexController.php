<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Docs\SearchIndex;
use Illuminate\Http\JsonResponse;

class SearchIndexController extends Controller
{
    public function __invoke(SearchIndex $searchIndex): JsonResponse
    {
        return response()->json([
            'version' => config('ui-docs.version'),
            'entries' => $searchIndex->all(),
        ]);
    }
}
