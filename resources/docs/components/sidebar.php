<?php

declare(strict_types=1);

return [
    'slug' => 'sidebar',
    'name' => 'Sidebar',
    'description' => 'Collapsible application sidebar with section headings, icon and label items, active states, and mobile off-canvas overlay.',
    'category' => 'layout',
    'tags' => ['sidebar', 'shell', 'navigation'],
    'props' => [
        [
            'name' => 'collapsed',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Initial collapsed desktop width showing icons only.',
        ],
        [
            'name' => 'label',
            'type' => 'string',
            'default' => 'Sidebar',
            'description' => 'Accessible name for the navigation landmark.',
        ],
        [
            'name' => 'item.current',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Marks the active destination with aria-current="page".',
        ],
    ],
    'a11yNotes' => [
        'Sidebar is a nav landmark with an accessible label.',
        'Active items set aria-current="page".',
        'Collapsed desktop mode keeps icon affordances and uses title tooltips for labels.',
        'Mobile off-canvas mode traps focus with x-trap and closes on Escape or overlay click.',
        'Dispatch ui-sidebar-open on window to open the mobile drawer from a sibling control.',
    ],
    'examples' => [
        [
            'slug' => 'ops-menu',
            'title' => 'Operations menu',
            'description' => 'Sections for penjualan and inventori in an SME ops app.',
        ],
    ],
];
