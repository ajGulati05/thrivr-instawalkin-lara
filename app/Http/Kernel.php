<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
         \Fruitcake\Cors\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
           \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class

        ],

        'api' => [
            'bindings',

        ],
        'managersapi'=>[
          'bindings',
           \App\Http\Middleware\VerifyCsrfToken::class,
           'can'
          
        ]

    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'passwordchange'=>\App\Http\Middleware\ManagerPasswordResetDate::class,
        'profilecompleted' => \App\Http\Middleware\ManagerProfileCompleted::class,
        'manageraccess' => \App\Http\Middleware\ManagerProfileCompleted::class,
        'assignGuard' =>\App\Http\Middleware\AssignGuard::class,
        'AddPassportParams'=>\App\Http\Middleware\AttachPassportInformation::class,
        'userType'=>\App\Http\Middleware\DetermineUserType::class,
        'dencryptForm'=>\App\Http\Middleware\DencryptForms::class,
        'customSigned'=>\App\Http\Middleware\CustomHasValidSignature::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        //'refreshToken' =>\App\Http\Middleware\refreshTokenIfExpired::class, //this is the original
        //'jwt-auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
        //'jwt-refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
        
    ];
}
