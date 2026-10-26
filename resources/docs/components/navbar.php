<?php

declare(strict_types=1);

return [
    'slug' => 'navbar',
    'name' => 'Navbar',
    'description' => 'Responsive top application bar with brand mark, desktop links, header actions, and a teleported Alpine mobile drawer or floating sheet.',
    'category' => 'layout',
    'tags' => ['navbar', 'shell', 'drawer', 'mobile', 'header'],
    'props' => [
        [
            'name' => 'brandHref',
            'type' => 'string',
            'default' => '/',
            'description' => 'URL destination for the brand logo or title.',
        ],
        [
            'name' => 'brandName',
            'type' => 'string',
            'default' => 'Praesepe UI',
            'description' => 'Fallback text label used when the brand slot is empty.',
        ],
        [
            'name' => 'sticky',
            'type' => 'bool',
            'default' => 'true',
            'description' => 'Pins the navigation bar to the top of the viewport with backdrop blur.',
        ],
        [
            'name' => 'mobileStyle',
            'type' => 'string',
            'default' => 'drawer',
            'description' => 'Defines mobile layout: "drawer" teleports a slide-over sheet to body; "floating" renders a detached card menu under the header.',
        ],
        [
            'name' => 'slots',
            'type' => 'brand|logo|links|actions|mobileBarActions|mobileLinks|mobileFooter',
            'default' => 'n/a',
            'description' => 'Named slots for custom brand text, custom logo mark, desktop links, header actions, mobile top-bar buttons, alternate mobile links, and drawer footer elements.',
        ],
    ],
    'a11yNotes' => [
        'The mobile menu toggle button correctly exposes aria-expanded and aria-controls linking to the drawer panel.',
        'The mobile sheet uses role="dialog", aria-modal="true", and @alpinejs/focus (x-trap.inert.noscroll) to trap keyboard focus while open.',
        'Pressing Escape closes the drawer. Clicking the backdrop overlay (in drawer style) or outside bounds (in floating style) also dismisses it.',
        'Automatic window resizing to md+ breakpoints forces the mobile menu closed to prevent focus trap issues or layout breaks.',
        'Active navigation links should leverage aria-current="page" for screen reader announcements.',
        'All mobile links enforce a minimum touch target height of 40px (h-10) for ergonomic thumb navigation.',
    ],
    'examples' => [
        [
            'slug' => 'app-shell',
            'title' => 'App shell navbar',
            'description' => 'Back-office top bar configuration featuring mobile drawer, theme toggles, and user actions.',
        ],
        [
            'slug' => 'marketing',
            'title' => 'Public marketing navbar',
            'description' => 'Minimalist top navigation bar for public-facing landing pages with a floating mobile sheet.',
        ],
    ],
];
