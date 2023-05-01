<?php

namespace App\Http\Controllers\Usersapi\v2;


use App\User;
use App\Guest;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Userprofile;
use Illuminate\Support\Str;
//ndefined constant 'App\Http\Controllers\UserAuthMobile\Http\Request
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\PassportAuthService;
//use Illuminate\Support\Facades\Auth;
use App\Helpers\PhoneMaskerClass;


use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\v2\MergeGuestToUserTrait;
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
    use VerifiesEmails;
    use MergeGuestToUserTrait;

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

  
    public function createAll(Request $request){
           $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|string|min:17|max:17'
            
        ]);
 


    

     //if 302 return then validation failed
        $user= $this->create($request->all());
        $user->update([
            'instauuid'=>(string) Str::orderedUuid()]);
        $user_id = $user->id;
        $firstname = request('firstname');
        $lastname = request('lastname');
        $phone=PhoneMaskerClass::removeMask(request('phone'));
        Userprofile::Create([
            'user_id' => $user_id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone
        ]);
    return $user;
    }


public function consumePassportLogin(Request $request){
    $PassportAuthService = new PassportAuthService();
    $response = $PassportAuthService->login($request);
     $decodedResponse= json_decode((string) $response->getBody(), true);
    return response()->json(['data'=>$decodedResponse,'status'=>$response->getReasonPhrase()=="OK"?true:false], $response->getStatusCode());
    
}

        /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

   
        $user=$this->createAll($request);

        event(new Registered($user));
    
        return $this->consumePassportLogin($request);
                    
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
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {


        $guest=Guest::find($request->route('id'));
        //Get User
        if (! hash_equals((string) $request->route('id'), (string) $guest->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($guest->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($guest->hasVerifiedEmail()) {
            return  new JsonResponse(['status'=>true,'message'=>"You are already verified"], 200);
                
        }

        if ($guest->markEmailAsVerified()) {
            event(new Verified($guest));
        }
        //fix phone
        if(isset($guest->phone)){
              $request->merge(['phone'=>"+1 (306) 262-5152"]);
        }
       $request->merge(['firstname'=>$guest->firstname]);
         $request->merge(['email'=>$guest->email]);
           $request->merge(['lastname'=>$guest->lastname]);
          

          $user=$this->createAll($request);
          $guest->user_id=$user->id;
          $guest->save();

          $user->markEmailAsVerified();
          $this->onVerification($guest);

           return $this->consumePassportLogin($request);
    }

    
}
