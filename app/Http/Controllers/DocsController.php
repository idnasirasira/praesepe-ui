<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Docs\ComponentRegistry;
use App\Docs\IconCatalog;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocsController extends Controller
{
    public function __construct(
        private readonly ComponentRegistry $registry,
        private readonly IconCatalog $icons,
    ) {}

    public function index(): View
    {
        return view('docs.index');
    }

    public function theming(): View
    {
        return view('docs.theming');
    }

    public function accessibility(): View
    {
        return view('docs.accessibility');
    }

    public function icons(): View
    {
        return view('docs.icons', [
            'icons' => $this->icons->all(),
        ]);
    }

    public function mcp(): View
    {
        return view('docs.mcp', [
            'mcpUrl' => url('/mcp/praesepe-ui'),
        ]);
    }

    public function components(): View
    {
        return view('docs.components.index', [
            'components' => $this->registry->all(),
        ]);
    }

    public function show(string $slug): View
    {
        $page = $this->registry->find($slug);

        if ($page === null) {
            throw new NotFoundHttpException("Component [{$slug}] was not found.");
        }

        return view('docs.components.show', [
            'page' => $page,
            'examples' => $this->registry->examplesFor($page),
        ]);
    }
}
