<?php

namespace App\Http\Controllers\Usersapi\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Userprofile;
use App\UserNotifications;
use Config;
use Lcobucci\JWT\Parser;
use App\OauthAccessToken;
use SebastianBergmann\Environment\Console;
use App\Events\Laravel\Passport\Events\AccessTokenCreated;
use App\Http\Resources\UsersSessionResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
//TODO: TAKE AS REFERENCE THE VENDOR_OVERRIDE AUTHENTICATE USERS TRAIT
use Illuminate\Support\Facades\Validator;

use Laravel\Passport\Passport;



use League\OAuth2\Server\Exception\OAuthServerException;
use App\Services\PassportAuthService;


class AuthUsersController extends Controller
{


 public function loginUser(Request $request){
    
        $PassportAuthService = new PassportAuthService();
        $response = $PassportAuthService->login($request);
         $decodedResponse= json_decode((string) $response->getBody(), true);
        return response()->json(['data'=>$decodedResponse,'status'=>$response->getReasonPhrase()=="OK"?true:false], $response->getStatusCode());
       
    }



 public function setPassword(Request $request){

       $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string'
            
        ]);
 

 
        $user = Auth::user();
if($this->authorize('canTheUserUpdatePassword',$user)){
if (Hash::check($request->current_password, $user->password)) {


   $user->fill([
            'password' => Hash::make($request->password)
        ])->save();
    return response()->json(["message"=>"Your password has been changed","status"=>true],200);
}
       return response()->json(["message"=>"Please check your current password","error"=>"Please check your current password","status"=>false],422);
    }
}
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }



    public function logoutUser(Request $request)
    {
       
      
          
                    $user = Auth::user()->token();
                    $user->revoke();
                
                    return response()->json(["message"=>"You are now logged out.","status"=>true], 204);
     
 
      
    }

  public function refreshPassportToken(Request $request)
    { 

       $PassportAuthService = new PassportAuthService();

        $response = $PassportAuthService->refresh($request);
          $decodedResponse= json_decode((string) $response->getBody(), true);
        return response()->json(['data'=>$decodedResponse,'status'=>$response->getReasonPhrase()=="OK"?true:false], $response->getStatusCode());
        
    }
 
   public function checkAuth(){
       
             if (Auth::guard('usersapi')->check() == 1) {
                 return response()->json(['status'=>true],200);
         }
             else {
                 return response()->json(['status'=>false],401);
             }
         }
  


}
