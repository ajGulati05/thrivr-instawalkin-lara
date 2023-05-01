<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PassportProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
       // $loader->alias('Laravel\Passport\Bridge\UserRepository', 'App\Http\Vendor_override\UserRepository');
       // $loader->alias('League\OAuth2\Server\Grant\PasswordGrant', 'App\Http\Vendor_override\PasswordGrant');
       // $loader->alias('Illuminate\Foundation\Auth\SendsPasswordResetEmails', 'App\Http\Vendor_override\SendsPasswordResetEmails');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
