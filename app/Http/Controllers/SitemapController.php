<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Docs\ComponentRegistry;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(ComponentRegistry $registry): Response
    {
        $urls = [
            route('home'),
            route('docs.index'),
            route('docs.theming'),
            route('docs.accessibility'),
            route('docs.icons'),
            route('docs.components.index'),
            route('ui.index'),
            route('themes.index'),
        ];

        foreach ($registry->all() as $component) {
            $urls[] = route('docs.components.show', $component->slug);
        }

        $xml = view('seo.sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
