<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class PassportAuthService
{


public function login(Request $request){



    $response = Http::asForm()->post(config('app.passport_url'), [
       
            'client_id' => request('client_id'),
            'client_secret' => request('client_secret'),
            'scope' => '*',
            'username'=>request('email'),
            'password'=>request('password'),
            'grant_type' => request('grant_type')
        
    ]);

   
  return $response;


}




public function sociallogin(Request $request)
{



    $response = Http::asForm()->post(config('app.passport_url'), [
       
            'client_id' => request('client_id'),
            'client_secret' => request('client_secret'),
            'grant_type' => request('grant_type'),
            'access_token'=>request('access_token'),
            'provider'=>request('provider')
        
    ]);
     return $response;
   


}



public function refresh(Request $request)
{



$response = Http::asForm()->post(config('app.passport_url'), [
            'client_id' => request('client_id'),
            'client_secret' => request('client_secret'),
            'scope' => '*',
            'grant_type' => request('grant_type'),
            'refresh_token'=> request('refresh_token')
    ]);
  return $response;
   
  


}
}