<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification. FOR POSTMAN TESTS
     *
     * @var array
     */
    protected $except = [
        //
        '/locationResource',
        '/usersapi/*',
        '/usersapi/locationResource',
        '/usersapi/history',
        '/usersapi/updateExpoToken',
        '/servicecategories/restoremodel/*',
        '/usersapiv2/*',
        '/usersapiv3/*',
        '/managersapi/*',
        '/oauth/*',  //FOR TESTING NEW ROUTES
        '/usersapi/*', //FOR TESTING,
        '/stripe/*',
        '/timekit_booking_webhook',
      //  '/therapist/*',
        '/broadcasting/auth',
        '/contact-us',
        '/ctarecord',
        '/city-banner',
        '/request-demo/*',
        '/email/*',
        '/guest/email/*'

    ];
}
