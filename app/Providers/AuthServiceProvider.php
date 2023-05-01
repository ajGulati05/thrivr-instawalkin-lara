<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Stripedata;
use App\Policies\StripedataPolicy;
use App\Booking;
use App\Policies\BookingPolicy;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use App\User;
use App\Policies\UserPolicy;
use App\Manager;
use App\Policies\ManagerPolicy;
use App\Guest;
use App\Policies\GuestPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
     
  Stripedata::class => StripedataPolicy::class,
       Booking::class => BookingPolicy::class,
        User::class=>UserPolicy::class,
        Manager::class=>ManagerPolicy::class,
         Guest::class => GuestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        //passport::$revokeOtherTokens;
        //passport::$pruneRevokedTokens;
        //  Passport::tokensExpireIn(now()->addMinute(61));
        Passport::tokensExpireIn(now()->addDays(100));

        // Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::refreshTokensExpireIn(now()->addDays(100));
       
    }
}
