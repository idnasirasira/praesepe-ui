<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Docs\ComponentRegistry;
use Illuminate\Contracts\View\View;

class UiController extends Controller
{
    public function __construct(
        private readonly ComponentRegistry $registry,
    ) {}

    public function __invoke(): View
    {
        return view('ui.index', [
            'components' => $this->registry->all(),
        ]);
    }
}
