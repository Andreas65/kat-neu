<?php

use Application\FrontendConfig\Foobar;

return [
    'unister_travelpackages_frontendconfig' => [
        'config' => [
            'portalName' => 'Ab-In-Den-Urlaub.de',
            'someconfiguration' => [
                'test' => 1
            ],
        ],
        'strategies' => [
            'foobar'
        ],
        'plugins' => [
            'invokables' => [
                'foobar' => Foobar::class,
            ]
        ]
    ]
];
