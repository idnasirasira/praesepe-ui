<?php

declare(strict_types=1);

return [
    'slug' => 'avatar',
    'name' => 'Avatar',
    'description' => 'User and customer avatars with image error fallback to initials or icon, status dots, and overlapping group stacks.',
    'category' => 'data-display',
    'tags' => ['avatar', 'user', 'group'],
    'props' => [
        [
            'name' => 'src',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Image URL. On error, Alpine shows initials or the fallback icon.',
        ],
        [
            'name' => 'name',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Used to build initials and accessible labels.',
        ],
        [
            'name' => 'size',
            'type' => 'xs|sm|md|lg|xl',
            'default' => 'md',
            'description' => 'Avatar diameter and type scale.',
        ],
        [
            'name' => 'status',
            'type' => 'online|busy|offline|null',
            'default' => 'null',
            'description' => 'Optional presence indicator dot.',
        ],
        [
            'name' => 'group.overflow',
            'type' => 'slot',
            'default' => 'null',
            'description' => 'Overflow counter content such as +3 for avatar groups.',
        ],
    ],
    'a11yNotes' => [
        'When name or alt is provided, the avatar uses role="img" with an accessible label.',
        'Broken images are swapped to initials or a decorative user icon via Alpine x-on:error without leaving an empty broken image.',
        'Status dots include an sr-only Status label plus a title (Online, Busy, Offline). Do not rely on color alone.',
        'Avatars use an inset hairline so light photos do not bleed into light surfaces, plus ring-2 ring-surface for group stacking.',
    ],
    'examples' => [
        [
            'slug' => 'customers',
            'title' => 'Ops team presence',
            'description' => 'Finance, warehouse, and procurement staff with online, busy, and offline status.',
        ],
        [
            'slug' => 'sizes',
            'title' => 'Sizes',
            'description' => 'xs through xl density scale with SME role labels.',
        ],
        [
            'slug' => 'group',
            'title' => 'Avatar group',
            'description' => 'Overlapping stack with +N overflow for assigned agents.',
        ],
    ],
];
