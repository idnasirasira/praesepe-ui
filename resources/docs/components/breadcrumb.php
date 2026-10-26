<?php

declare(strict_types=1);

return [
    'slug' => 'breadcrumb',
    'name' => 'Breadcrumb',
    'description' => 'Accessible breadcrumb navigation with optional home icon, chevron separators, and aria-current on the final page.',
    'category' => 'navigation',
    'tags' => ['breadcrumb', 'nav'],
    'props' => [
        [
            'name' => 'homeHref',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Optional leading home link URL.',
        ],
        [
            'name' => 'homeLabel',
            'type' => 'string',
            'default' => 'Home',
            'description' => 'Accessible label for the home icon link.',
        ],
        [
            'name' => 'item.href',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Link target. Omit or set current for the final crumb.',
        ],
        [
            'name' => 'item.current',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Marks the final item with aria-current="page".',
        ],
    ],
    'a11yNotes' => [
        'Uses nav aria-label="Breadcrumb" wrapping an ordered list.',
        'The current page sets aria-current="page", uses font-medium text-fg, and is not a link.',
        'Ancestor links include focus-visible rings and hover:text-fg transition-colors.',
        'On narrow viewports the trail scrolls horizontally (overflow-x-auto whitespace-nowrap) with max-w-[12rem] truncate on intermediate crumbs.',
        'Separators and the decorative home icon are aria-hidden. Home keeps a screen-reader-only text label.',
    ],
    'examples' => [
        [
            'slug' => 'app-path',
            'title' => 'App path',
            'description' => 'Orders section breadcrumb for an SME back office.',
        ],
        [
            'slug' => 'with-home',
            'title' => 'With home icon',
            'description' => 'Leading home control before the trail.',
        ],
    ],
];
