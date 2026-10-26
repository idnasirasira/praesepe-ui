<?php

declare(strict_types=1);

return [
    'slug' => 'alert',
    'name' => 'Alert',
    'description' => 'Static inline banner for info, success, warning, and danger messages with optional dismiss control.',
    'category' => 'feedback',
    'tags' => ['alert', 'banner', 'status'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'info|success|warning|danger',
            'default' => 'info',
            'description' => 'Semantic tone and soft background treatment.',
        ],
        [
            'name' => 'title',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Optional bold heading above the body slot.',
        ],
        [
            'name' => 'dismissible',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Adds a dismiss button that hides the alert via Alpine show state.',
        ],
    ],
    'a11yNotes' => [
        'danger uses role="alert". Other variants use role="status" to avoid interrupting the user unnecessarily.',
        'Decorative icons are aria-hidden. The dismiss button has an accessible name.',
        'Dismissible alerts use x-show and x-cloak. They are removed from the accessibility tree when hidden.',
    ],
    'examples' => [
        [
            'slug' => 'variants',
            'title' => 'Variants',
            'description' => 'info, success, warning, and danger banners.',
        ],
        [
            'slug' => 'dismissible',
            'title' => 'Dismissible',
            'description' => 'Optional dismiss button with Alpine show state.',
        ],
    ],
];
