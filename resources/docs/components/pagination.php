<?php

declare(strict_types=1);

return [
    'slug' => 'pagination',
    'name' => 'Pagination',
    'description' => 'Numbered pagination with ellipsis windowing and a simple Previous/Next variant with result range summary.',
    'category' => 'navigation',
    'tags' => ['pagination', 'pager'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'numbered|simple',
            'default' => 'numbered',
            'description' => 'Page button list or compact previous/next controls.',
        ],
        [
            'name' => 'current',
            'type' => 'int',
            'default' => '1',
            'description' => 'Active page number.',
        ],
        [
            'name' => 'total',
            'type' => 'int',
            'default' => '1',
            'description' => 'Total number of pages.',
        ],
        [
            'name' => 'perPage',
            'type' => 'int',
            'default' => '10',
            'description' => 'Items per page used for the range summary.',
        ],
        [
            'name' => 'totalItems',
            'type' => 'int|null',
            'default' => 'null',
            'description' => 'Total item count. Defaults to total * perPage when omitted.',
        ],
    ],
    'a11yNotes' => [
        'Wraps controls in nav with aria-label="Pagination".',
        'The active page link sets aria-current="page".',
        'Disabled previous/next links use aria-disabled="true" and tabindex="-1".',
        'Ellipsis markers are aria-hidden decorative separators.',
    ],
    'examples' => [
        [
            'slug' => 'numbered',
            'title' => 'Numbered',
            'description' => 'Ellipsis window around the current invoice page.',
        ],
        [
            'slug' => 'simple',
            'title' => 'Simple',
            'description' => 'Previous/Next with Showing X to Y of Z results.',
        ],
    ],
];
