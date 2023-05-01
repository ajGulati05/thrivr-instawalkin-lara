<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Log;
class AttachTherapistPassportInformation
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

    $email = $request->email;
    $password = $request->password;
   
    $request->merge(['grant_type' => $request->grant_type]);
    $request->merge(['client_id' =>  config('constants.passport-variables.mix_client_id')]);
    $request->merge(['client_secret' => config('constants.passport-variables.mix_client_secret')]);

    $request->merge(['scope' => '*']);
    $request->merge(['customProvider' => 'managersapi']);
    $request->merge(['password' => $password]);
    $request->merge(['email' => $email]);

Log::debug($request);
    return $next($request);
  }
}
