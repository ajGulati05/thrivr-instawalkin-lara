<?php

namespace App\Http\Controllers\ManagersApi;


use App\Manager;


use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Str;
//ndefined constant 'App\Http\Controllers\UserAuthMobile\Http\Request

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\PassportAuthService;
use Illuminate\Validation\Rule;

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
        return User::create([
            
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

   
   $request->validate([
            'email' => 'bail|required|string|email|max:255|unique:managers',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'gender'=>  ['required',Rule::in(['M','F','O'])],
            'timezone'=>'required|string|min:2',
            'business_name'=>'required|string'
        ]);
 

 $timeZone=str_replace('_','/',request('timezone'));

    
      
     //if 302 return then validation failed
     $manager=   Manager::create(
            [
                'email'=>request('email'),
                'password'=>bcrypt(request('password')),
                'first_name'=>request('firstname'),
                'last_name'=>request('lastname'),
                'gender'=>request('gender'),
                'timezone'=>$timeZone,
                'business_name'=>request('business_name'),
                'product_code'=>'L',
                'status'=>false


            ]);

     //   $manager->sendEmailVerificationNotification();
      $PassportAuthService = new PassportAuthService();
      $response = $PassportAuthService->login($request);
       
            $decodedResponse= json_decode((string) $response->getBody(), true);
        return response()->json(['data'=>$decodedResponse,'status'=>$response->getReasonPhrase()=="OK"?true:false], $response->getStatusCode());
    
    
                    
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
    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    
}
