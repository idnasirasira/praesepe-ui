<?php

declare(strict_types=1);

return [
    'slug' => 'navbar',
    'name' => 'Navbar',
    'description' => 'Responsive top application bar with brand, desktop links, actions, and an Alpine mobile drawer using focus trap and Escape close.',
    'category' => 'layout',
    'tags' => ['navbar', 'shell', 'drawer'],
    'props' => [
        [
            'name' => 'brandHref',
            'type' => 'string',
            'default' => '/',
            'description' => 'URL for the brand mark.',
        ],
        [
            'name' => 'slots',
            'type' => 'brand|links|actions',
            'default' => 'n/a',
            'description' => 'Named slots for brand text, primary links, and right-side actions.',
        ],
    ],
    'a11yNotes' => [
        'Mobile menu button exposes aria-expanded and aria-controls for the drawer panel.',
        'The drawer uses role="dialog", aria-modal="true", and x-trap.inert.noscroll while open.',
        'Escape closes the drawer. Overlay click also closes it.',
        'Active links should set aria-current="page" via x-ui.navbar.link current prop.',
    ],
    'examples' => [
        [
            'slug' => 'app-shell',
            'title' => 'App shell navbar',
            'description' => 'SME back-office top bar with sales links and actions.',
        ],
    ],
];
