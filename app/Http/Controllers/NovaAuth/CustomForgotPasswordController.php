<?php

namespace App\Http\Controllers\NovaAuth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravel\Nova\Http\Controllers\ForgotPasswordController;
class CustomForgotPasswordController extends ForgotPasswordController
{
   
    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
     //Password Broker for Seller Model
  //Password Broker for Seller Model
    public function broker()
    {
         return Password::broker('admins');
    }
}
