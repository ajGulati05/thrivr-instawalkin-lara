<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ManagerPasswordResetDate
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
        if(is_null(Auth::user()->lastpasswordchange_date))
            {   
                return redirect()->route('manager.firsttime')->send();
            }
        return $next($request);
    }
    
}
