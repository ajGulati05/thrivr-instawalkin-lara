<?php

namespace App\Http\Controllers\UserAuthMobile;


use App\User;
use App\UserProfile;
use App\Stripedata;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use JWTAuth;
use JWTAuthException;

//ndefined constant 'App\Http\Controllers\UserAuthMobile\Http\Request

use Illuminate\Foundation\Auth\AuthenticatesUsers;


//use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
 /**
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorCheck(array $data)
    {
           
         $validator= Validator::make($data, [
            
        ]);

         return $validator;
         
     
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
         User::create([
            
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);


    }

        /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

     $validator = Validator::make($request->all(), [
            'email' => 'bail|required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            
        ]);

    if ($validator->fails())
        {
      return response()->json(['error'=>'true','message'=>json_encode($validator->errors()),'code'=>'400']);
    
         }

     //if 302 return then validation failed
         $user= $this->create($request->all());
    
       

        //$this->createStripeData($user->email,$user->id);
       return response()->json(['error'=>'false','message'=>'Succesfully Registered','code'=>'200']);
  
                    
    }

        /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
       
    }

    protected function makeUsersNotification()
    {

    }




    
}
