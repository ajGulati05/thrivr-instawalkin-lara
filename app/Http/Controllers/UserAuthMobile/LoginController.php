<?php

namespace App\Http\Controllers\UserAuthMobile;
use App\User;
use App\Userprofile;
use App\Stripedata;
use App\UserNotifications;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JWTAuth;
use JWTAuthException;
use TokenExpiredException;
use Illuminate\Contracts\Auth\Authenticatable;
use Promocodes;
use Gabievi\Promocodes\Exceptions\AlreadyUsedException;
use Gabievi\Promocodes\Exceptions\InvalidPromocodeException;
use Illuminate\Support\Facades\Log;
 use App\Http\Resources\UsersApi\PromocodehistoryResource;
 use Carbon\Carbon;
use App\Corporationpromouser;
//use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest:api', ['except' => 'logout']);
    }

 public function login(Request $request){
    
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error'=>'true','message'=>['email'=>'Invalid email and password', 'password'=>'Invalid email and password'], 'code'=>'401'],401);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['error'=>'true','message'=>['email'=>'We are having some technical difficulties.','password'=>'We are having some technical difficulties.'], 'code'=>'500'], 500);
        }

        $user=JWTAuth::toUser($token); 
        $usersprofile= $user->userprofiles;
        $stripedata=$user->stripedata;
        $notifications=$user->usernotifications;
        $credits=$user->usercredits;
        $promocodes=$user->promocodes()->whereDate('expires_at','>=',Carbon::now())->orderBy('expires_at')->get();
        $returnVal=  PromocodehistoryResource::collection($promocodes)->keyBy('code'); 
        $corporationpromouser= optional($user->corporationpromousers)->validated?$user->corporationpromousers->corporationpromos:null;
         
        //return response()->json(['error'=>'false','user'=>auth()->user()->email,'expoDbToken'=>auth()->user()->expotoken,'tokens'=>$token,'usersprofile'=>$usersprofile,'stripedata'=>$stripedata,'notifications'=>$notifications, 'code'=>'200'],200);


          return response()->json(['error'=>'false','user'=>auth()->user()->email,'expoDbToken'=>auth()->user()->expotoken,'tokens'=>$token,'usersprofile'=>$usersprofile,'credits'=>$credits,'corporationpromouser'=>$corporationpromouser,'notifications'=>$notifications,'stripedata'=>$stripedata, 'promocode'=>$returnVal,'code'=>'200'],200);
        //return response()->json(["tokens"=>['type'=>'header','value'=>$token],"user"=>['id'=>'55']
        //]);
    }

public function refresh(Request $request)
    {
        $token = null;
        try {
            $token = JWTAuth::getToken();
            $token =  JWTAuth::refresh($token);
            $user = JWTAuth::toUser($token);
         // $token =  JWTAuth::refresh($tokenOld);
          $notifications=$user->usernotifications;
          $stripedata=$user->stripedata;
        } catch(TokenExpiredException $e) {
    //token cannot be refreshed, user needs to login again
    
                return response()->json(['error' =>'true','message'=>'Need to Login Again','code'=>'401'],401);
   
        }

        return response()->json(['error'=>'false','tokens'=>$token,'notifications'=>$notifications,'stripedata'=>$stripedata,'code'=>'200'],200);
    }
    

    public function reload(Request $request)
    {
        $token = null;
        try {
            $token = JWTAuth::getToken();
           
            $user = JWTAuth::toUser($token);
         // $token =  JWTAuth::refresh($tokenOld);
          $notifications=$user->usernotifications;
          $stripedata=$user->stripedata;
          $credits=$user->usercredits;
              $promocodes=$user->promocodes()->whereDate('expires_at','>=',Carbon::now())->orderBy('expires_at')->get();
    $returnVal=  PromocodehistoryResource::collection($promocodes)->keyBy('code'); 
     $corporationpromouser= optional($user->corporationpromousers)->validated?$user->corporationpromousers->corporationpromos:null;
        } catch(TokenExpiredException $e) {
    //token cannot be refreshed, user needs to login again
    
                return response()->json(['error' =>'true','message'=>'Need to Login Again','code'=>'401'],401);
   
        }

        return response()->json(['error'=>'false','expoDbToken'=>auth()->user()->expotoken,'notifications'=>$notifications,'credits'=>$credits,'stripedata'=>$stripedata,'corporationpromouser'=>$corporationpromouser,'promocode'=>$returnVal,'code'=>'200'],200);
    }
   /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
      //  return Auth::guard('api');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        
    }

   
}
