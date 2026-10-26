<?php

declare(strict_types=1);

return [
    'slug' => 'accordion',
    'name' => 'Accordion',
    'description' => 'Compound disclosure sections with single or multiple open items, ARIA expanded/controls pairing, and motion-safe height transitions.',
    'category' => 'disclosure',
    'tags' => ['accordion', 'disclosure', 'collapse'],
    'props' => [
        [
            'name' => 'type',
            'type' => 'single|multiple',
            'default' => 'single',
            'description' => 'single keeps one panel open. multiple allows several panels open together.',
        ],
        [
            'name' => 'default',
            'type' => 'string|array|null',
            'default' => 'null',
            'description' => 'Initially open item id, or list of ids when type is multiple.',
        ],
        [
            'name' => 'item.id',
            'type' => 'string',
            'default' => 'required',
            'description' => 'Stable id for the accordion item.',
        ],
        [
            'name' => 'item.title',
            'type' => 'string',
            'default' => 'required',
            'description' => 'Header button label.',
        ],
    ],
    'a11yNotes' => [
        'Header buttons expose x-bind:aria-expanded and aria-controls pointing at the panel id.',
        'Panels use role="region" and aria-labelledby pointing back at the header button.',
        'Keyboard: Tab moves between headers. Enter or Space toggles the focused header (native button behavior).',
        'Height and opacity transitions respect prefers-reduced-motion via motion-reduce utilities and global reduced-motion overrides.',
    ],
    'examples' => [
        [
            'slug' => 'single',
            'title' => 'Single type',
            'description' => 'Only one panel open at a time.',
        ],
        [
            'slug' => 'multiple',
            'title' => 'Multiple type',
            'description' => 'Several panels can stay open together.',
        ],
    ],
];
