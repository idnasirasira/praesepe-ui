<?php

declare(strict_types=1);

return [
    'name' => 'Praesepe UI',
    'version' => '0.1.0',
    'praesepe_url' => 'https://praesepe.id',
    'whatsapp_url' => 'https://wa.me/6285117170755',
    'email' => 'praesepe@idnasirasira.com',
    'github_url' => 'https://github.com/idnasirasira/praesepe-ui',
    'navigation' => [
        [
            'label' => 'Getting started',
            'items' => [
                ['label' => 'Installation', 'route' => 'docs.index'],
                ['label' => 'Theming', 'route' => 'docs.theming'],
                ['label' => 'Accessibility', 'route' => 'docs.accessibility'],
            ],
        ],
        [
            'label' => 'Components',
            'items' => [
                ['label' => 'All components', 'route' => 'docs.components.index'],
            ],
        ],
        [
            'label' => 'Explore',
            'items' => [
                ['label' => 'Kitchen sink', 'route' => 'ui.index'],
                ['label' => 'Themes', 'route' => 'themes.index'],
            ],
        ],
    ],
];
