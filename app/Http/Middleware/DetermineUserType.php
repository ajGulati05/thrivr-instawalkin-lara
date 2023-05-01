<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\User;
use App\Guest;
use App\GuestUser;

class DetermineUserType
{

    protected $client="User:";
    protected $userGuest="UserGuest:";
    protected $guest= "Guest:";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {



            


            if(Str::startsWith(request('instauuid'),$this->userGuest)){
              $uuid=  (string)  Str::of(request('instauuid'))->replace($this->userGuest,'');
            $userGuestModel=UserGuest::where('instauuid',$uuid)->first();
             $request->merge(['userGuest'=>$userGuestModel  ]);
            }

            if(Str::startsWith(request('instauuid'),$this->guest)){
                   $uuid=  (string) Str::of(request('instauuid'))->replace($this->guest,'');
                    $guestModel=Guest::where('instauuid',$uuid)->first();
                    $request->merge(['guest'=>$guestModel ]);
            }
 if(Str::startsWith(request('instauuid'),$this->client)){
             $uuid= (string) Str::of(request('instauuid'))->replace($this->client,'');
            $userModel=User::where('instauuid',$uuid)->first();
            $request->merge(['user'=>$userModel ]);
     }      
      return $next($request);

}




}
