<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ThemesController extends Controller
{
    public function __invoke(): View
    {
        return view('themes.index', [
            'themes' => [
                [
                    'id' => 'praesepe',
                    'name' => 'Praesepe',
                    'description' => 'Indigo brand with cool slate neutrals.',
                ],
                [
                    'id' => 'minimal',
                    'name' => 'Minimal',
                    'description' => 'Sharp monochrome surfaces with tight radii.',
                ],
                [
                    'id' => 'warm',
                    'name' => 'Warm',
                    'description' => 'Teal brand on soft stone and sand neutrals.',
                ],
            ],
        ]);
    }
}
