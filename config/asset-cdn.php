<?php

return [

    'use_cdn' => env('USE_CDN', false),

    'cdn_url' => '',

    'filesystem' => [
        'disk' => 's3_cdn',

        'options' => [
            //
        ],
    ],

    'files' => [
        'ignoreDotFiles' => true,

        'ignoreVCS' => true,

        'include' => [
            'paths' => [
                'js', 
                'css',
                'images',
                'fonts',
                'frontendv2'
            ],
            'files' => [
            '*.js',
            '*.css',
            '*.jpg',
            '*.png',
            '*.jpeg',
            '*.svg',
            '*.ttf'
            ],
            'extensions' => [
                //
            ],
            'patterns' => [
                //
            ],
        ],

        'exclude' => [
            'paths' => [
                //
            ],
            'files' => [
                //
            ],
            'extensions' => [
                //
            ],
            'patterns' => [
                //
            ],
        ],
    ],

];
