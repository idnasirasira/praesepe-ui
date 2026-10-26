<?php

declare(strict_types=1);

return [
    'slug' => 'card',
    'name' => 'Card',
    'description' => 'Content container with default, sunken, and interactive variants using a stretched-link pattern for accessible click targets.',
    'category' => 'layout',
    'tags' => ['card', 'panel', 'stretched-link'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'default|sunken|interactive',
            'default' => 'default',
            'description' => 'Surface style. interactive enables hover affordance for clickable cards.',
        ],
        [
            'name' => 'href',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'When set, renders a stretched link over the card body without nesting interactive elements.',
        ],
    ],
    'a11yNotes' => [
        'Interactive cards use a single anchor with an absolutely positioned after pseudo-element so the whole card is clickable.',
        'Footer actions should use relative z-10 so buttons remain independently focusable above the stretched link.',
        'Focus-within outline appears on the card when the stretched link receives keyboard focus.',
        'Avoid placing nested links or buttons inside the stretched-link body. Put secondary actions in the footer slot.',
    ],
    'examples' => [
        [
            'slug' => 'order-summary',
            'title' => 'Order summary',
            'description' => 'Default card with header, body, and footer for an SME order.',
        ],
        [
            'slug' => 'interactive',
            'title' => 'Interactive customer card',
            'description' => 'Stretched-link card opening a customer profile.',
        ],
        [
            'slug' => 'sunken',
            'title' => 'Sunken metric',
            'description' => 'Low-emphasis sunken surface for dashboard metrics.',
        ],
    ],
];
