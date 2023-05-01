<?php

return [

 'paths' => ['*'],

    /*
    * Matches the request method. `[*]` allows all methods.
    */
    'allowed_methods' => ['*'],

    /*
     * Matches the request origin. `[*]` allows all origins.
     */
    'allowed_origins' => ['*'],
/*explode(',',env('ALLOWED_ORIGINS', 'http://thrivr.ca,http://therapist.thrivr.ca'))*/
    /*
     * Matches the request origin with, similar to `Request::is()`
     */
    'allowed_origins_patterns' => ['*'],

    /*
     * Sets the Access-Control-Allow-Headers response header. `[*]` allows all headers.
     */
    'allowed_headers' => [
        '*',
        'Content-Type',
        'X-Auth-Token',
        'Origin',
        'Authorization',
        'Access-Control-Allow-Origin'
    ],

    /*
     * Sets the Access-Control-Expose-Headers response header.
     */
    'exposed_headers' => ['X-Total-Count'],

    /*
     * Sets the Access-Control-Max-Age response header.
     */
    'max_age' => false,

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'supports_credentials' => false,
];

