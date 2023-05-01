<?php

namespace App\Http\Controllers\Usersapi;

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
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
//TODO: TAKE AS REFERENCE THE VENDOR_OVERRIDE AUTHENTICATE USERS TRAIT

class AuthUsersController extends Controller
{

    use AuthenticatesUsers;

    public function loginUser(Request $request)
    {
        
        Log::debug($request);


        // $this->validateLogin($request);
        $username = $request->email;
        $response = $this->login($request);


        if ($response->getStatusCode() == 200) {
            $user = User::where('email', $username)->first();

            $decoded_response = json_decode($response->getContent());

            $userSessionResourceRequest = new Request();
            $userSessionResourceRequest->user = $user;
            $userSessionResourceRequest->access_token = $decoded_response->access_token;
            $userSessionResourceRequest->refresh_token = $decoded_response->refresh_token;
            $userSessionResourceRequest->token_type = $decoded_response->token_type;
            $userSessionResourceRequest->expires_in = $decoded_response->expires_in;

            $userSessionResource = new UsersSessionResource($userSessionResourceRequest);

        

            return response($userSessionResource, 200);
        } else {
            return response('The user could not be authenticated', 401);
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
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('usersapi');
    }

    public function logoutUser(Request $request)
    {

        $user = Auth::user()->token();
        if ($user !== null) {

            $user->revoke();



            return response()->json([
                'message' => 'Successfully logged out', 'code' => '200'
            ], 200);
        } else {
            return response()->json([
                'error' => true, 'message' => 'User doesnt exist'
            ], 400);
        }
    }


    public function registerUser(Request $request)
    {
        Log::debug('PASSES SESSION RECOURSE');
        $validatedData = $request->validate([
            'email' => 'bail|required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|string|min:17|max:17',
        ]);
        Log::debug('GETS INTO REGISTER USER');
        $email = $request->email;
        $password = $request->password;

        $user = User::Create([
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        //these values are for user profile
        $user_id = $user->id;
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $toRemove = array(" ", "(", ")", "-");
        $toReplaceWith   = array("", "", "", "");
        $phone = $newphrase = str_replace($toRemove, $toReplaceWith, $request->phone);

        Userprofile::Create([
            'user_id' => $user_id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone
        ]);

       

        return response()->json(['error' => false, 'message' => true, 'code' => 200], 200);
    }
    public function editUser(Request $request)
    {
        $email = $request->email;
        //$password = $request->password; //TODO: find out how this is going to work.

        $user = User::where('email', $email)->first();

        //these values are for user profile
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $phone = $request->phone;

        Userprofile::updateOrCreate(
            [
                'user_id' => $user->id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone
            ]
        );

        return response()->json([
            'message' => 'User Updated'
        ]);
    }
}
