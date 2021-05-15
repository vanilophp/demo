<?php

return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'ui' => [
                'name' => 'Vanilo',
                'url' => '/admin/product'
            ]
        ],
        Vanilo\Framework\Providers\ModuleServiceProvider::class => [
            'image' => [
                'taxon' => [
                    'variants' => [
                        'thumbnail' => [
                            'width'  => 250,
                            'height' => 188,
                            'fit' => 'contain'
                        ],
                        'header' => [
                            'width'  => 1110,
                            'height' => 150,
                            'fit' => 'contain'
                        ],
                        'card' => [
                            'width'  => 521,
                            'height' => 293,
                            'fit' => 'contain'
                        ]
                    ]
                ],
                'variants' => [
                    'thumbnail' => [
                        'width'  => 250,
                        'height' => 188,
                        'fit' => 'fill'
                    ],
                    'medium' => [
                        'width'  => 540,
                        'height' => 406,
                        'fit' => 'fill'
                    ]
                ]
            ],
        ],
        Vanilo\Euplatesc\Providers\ModuleServiceProvider::class,
        Vanilo\Netopia\Providers\ModuleServiceProvider::class,
        Vanilo\Paypal\Providers\ModuleServiceProvider::class,
        Vanilo\Simplepay\Providers\ModuleServiceProvider::class,
        Vanilo\Stripe\Providers\ModuleServiceProvider::class,
    ]
];
