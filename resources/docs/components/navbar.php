<?php

declare(strict_types=1);

return [
    'slug' => 'navbar',
    'name' => 'Navbar',
    'description' => 'Responsive top application bar with brand, desktop links, actions, and a teleported Alpine mobile drawer or floating sheet.',
    'category' => 'layout',
    'tags' => ['navbar', 'shell', 'drawer', 'mobile'],
    'props' => [
        [
            'name' => 'brandHref',
            'type' => 'string',
            'default' => '/',
            'description' => 'URL for the brand mark.',
        ],
        [
            'name' => 'brandName',
            'type' => 'string',
            'default' => 'Praesepe UI',
            'description' => 'Fallback brand label when the brand slot is empty.',
        ],
        [
            'name' => 'sticky',
            'type' => 'bool',
            'default' => 'true',
            'description' => 'Pins the bar to the top with backdrop blur.',
        ],
        [
            'name' => 'mobileStyle',
            'type' => 'drawer|floating',
            'default' => 'drawer',
            'description' => 'drawer teleports a slide-over sheet to body. floating shows a detached card under the header.',
        ],
        [
            'name' => 'slots',
            'type' => 'brand|logo|links|actions|mobileBarActions|mobileLinks|mobileFooter',
            'default' => 'n/a',
            'description' => 'Named slots for brand text, logo mark, desktop links, desktop actions, mobile top-bar extras, alternate mobile links, and drawer footer.',
        ],
    ],
    'a11yNotes' => [
        'Mobile menu button exposes aria-expanded and aria-controls for the drawer panel.',
        'The drawer uses role="dialog", aria-modal="true", and x-trap.inert.noscroll while open.',
        'Escape closes the drawer. Overlay click (drawer style) or outside click (floating) also closes it.',
        'Resizing to md+ auto-closes the mobile menu to avoid stuck traps.',
        'Active links should set aria-current="page" via x-ui.navbar.link current prop.',
        'Mobile links use a minimum 40px tap height (h-10).',
    ],
    'examples' => [
        [
            'slug' => 'app-shell',
            'title' => 'App shell navbar',
            'description' => 'SME back-office top bar with drawer and floating mobile styles.',
        ],
    ],
];
