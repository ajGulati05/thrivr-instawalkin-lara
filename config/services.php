<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
 'postmark' => [
        'token' => '',
        'secret'=>'',
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'version' => env('STRIPE_API_VERSION'),
    ],
    'google_maps' => [
        'key' => env('GOOGLE_API_KEY'),
    ],
  'facebook' => [ 
                'client_id' => env ( 'FACEBOOK_APP_ID' ),
                'client_secret' => env ( 'FACEBOOK_APP_SECRET' ),
                'redirect' => env ( 'FACEBOOK_REDIRECT' ) 
        ],
  'google' => [ 
                'client_id' => env ( 'G_CLIENT_ID' ),
                'client_secret' => env ( 'G_CLIENT_SECRET' ),
                'redirect' => env ( 'G_REDIRECT' ) 
        ],
 
];
