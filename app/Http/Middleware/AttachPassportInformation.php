<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Closure;

class AttachPassportInformation
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {

    $email = request('email');
    $password =request('password');
  
    $request->merge(['grant_type' => 'password']);
    $request->merge(['client_id' =>  config('constants.passport_variables.mix_user_client_id')]);
    $request->merge(['client_secret' => config('constants.passport_variables.mix_user_client_secret')]);

    $request->merge(['scope' => '*']);
    $request->merge(['customProvider' => 'usersapi']);
    $request->merge(['password' => $password]);
    $request->merge(['email' => $email]);
     Log::debug("hello");
    Log::debug($request);

    return $next($request);
  }
}
