<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'defaultImg' => [
        'max' => ['with' => 1500, 'height' => 1500], //for validate
        'size'=> [
            'original' => ['width' => 0, 'height' => 0],
            'small' => ['width' => 80, 'height' => 0],
            'medium' => ['width' => 250, 'height' => 0],
            'large' => ['width' => 800, 'height' => 0],
        ]
    ],
    'data' => [
        'menu' => [
            'size'=> [
                '20x20' => ['width' => 20, 'height' => 20],
                'small' => ['width' => 80, 'height' => 0],
                'medium' => ['width' => 238, 'height' => 0],
                'medium2' => ['width' => 350, 'height' => 0],
                'large' => ['width' => 570, 'height' => 0],
                '560xauto' => ['width' => 560, 'height' => 0],
            ]
        ],
        'products' => [
            'size'=> [
                '346x415' => ['width' => 346, 'height' => 415],
                '381x422' => ['width' => 381, 'height' => 422],

            ]
        ],
        'feature' => [
            'dir' => 'feature',
            'max' => ['with' => 1500, 'height' => 1500], //for validate
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                '1920x762' => ['width' => 1920, 'height' => 762],
                'small' => ['width' => 100, 'height' => 0],
                'mediumx2' => ['width' => 350, 'height' => 0],
                '360x94' => ['width' => 360, 'height' => 94],
                '380x170' => ['width' => 380, 'height' => 170],
                '750x326' => ['width' => 750, 'height' => 326],
                'slide' => ['width' => 600, 'height' => 400],
                'category' => ['width' => 850, 'height' => 300],
            ]
        ],
        'config' => [
            'max' => ['with' => 845, 'height' => 845], //for validate
            'size'=> [
                'medium_seo' => ['width' => 250, 'height' => 0],
                'seo' => ['width' => 800, 'height' => 800],
            ]
        ],
        'config_home' => [
            'max' => ['with' => 845, 'height' => 845], //for validate
            'size'=> [
                'medium_seo' => ['width' => 250, 'height' => 0],
                '1170x916' => ['width' => 1170, 'height' => 916],
                '570x570' => ['width' => 570, 'height' => 570],
                '330x258' => ['width' => 330, 'height' => 258],
                '350x350' => ['width' => 350, 'height' => 350],
                'seo' => ['width' => 800, 'height' => 800],
            ]
        ],

        'file' => [],

        'customer' => [
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                '84x84' => ['width' => 84, 'height' => 84],
                '370x353' => ['width' => 370, 'height' => 353],
            ]
        ],
        'repice' => [
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                '1170x982' => ['width' => 1170, 'height' => 982],

            ]
        ],
        'choose' => [
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                '555x460' => ['width' => 555, 'height' => 460],

            ]
        ],
        'intro' => [
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                '600x392' => ['width' => 600, 'height' => 392],

            ]
        ],
    ]

];
