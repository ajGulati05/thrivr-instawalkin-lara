<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;

class DencryptForms
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


                
                                $request->merge(['active' => 1]);
                               $request->merge(['consent' => 1]);
                          return $next($request);
 


            }


}
