<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

use Laravel\Passport\Passport;
use App\Manager;
use Illuminate\Support\Facades\Auth;
use App\OauthAccessToken;
use League\OAuth2\Server\Exception\OAuthServerException;
use App\Http\Traits\GuzzleCallsTrait;
use App\GuzzleRequest;
use App\Vendor_override\AuthenticatesUsers;

class RefreshTokenIfExpiredPassport
{
    use AuthenticatesUsers;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // $guard="usersapi";

        if ($guard != null) {
    
            auth()->shouldUse($guard);

            //check if the user is actually signed in
           if (Auth::guard($guard)->check() == 1) {
            //  if (1!=1) {
                //carry on request as normal
       
                $response = $next($request);
            } else {

             
                //see if refresh token does exist
                $response = $this->refreshtoken($request);
                //get new access token 
              
               
                $new_acess_token = json_decode($response->getContent(), true)['access_token'];
               
                //set the access token for the next request
                $request->headers->set('Authorization', $new_acess_token); // check if you need to append bearer
                //send the next request
                $next_response = $next($request);
                //build the response with this 
                $response = response()->json(
                    [
                        'newtokens' => json_decode($response->getContent(), true),
                        'response' => json_decode($next_response->getContent(), true)
                    ],
                    200
                );
                //add the new tokens to response as well
            }


            return $response;
        } else {
            return response()->json([
                'code' => '400',
                'msg' => 'Authorization Failed'

            ], 400);
        }
    }
}
