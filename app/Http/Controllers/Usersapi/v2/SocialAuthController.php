<?php

namespace App\Http\Controllers\Usersapi\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Redirect;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

use App\Services\PassportAuthService;
class SocialAuthController extends Controller {
  use RegistersUsers;
  /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleSocial(Request $request)
    {



      $PassportAuthService = new PassportAuthService();
      $response = $PassportAuthService->socialLogin($request);
          $decodedResponse= json_decode((string) $response->getBody(), true);
        return response()->json(['data'=>$decodedResponse,'status'=>$response->getReasonPhrase()=="OK"?true:false], $response->getStatusCode());
    
                    
    }


    public function redirect($service) {
		return Socialite::driver($service)->redirect();
	}
	public function callback($service) {
		$user = Socialite::with($service)->user();
     dd($user);
	}

}

