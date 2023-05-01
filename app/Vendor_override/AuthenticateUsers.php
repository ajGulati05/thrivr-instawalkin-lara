<?php

namespace App\Vendor_override;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Config;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//THIS IS A MODEL FOR THE BEST PRACTICES
trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;



    public function registerUserapi(Request $request){

        Log::debug('PASSES REGISTRATION');

        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = config('app.passport_url');

        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth = null;

        //maybe this must be called from the mobile app
        $bodyGuzzle["grant_type"] = "password";
        $bodyGuzzle["client_id"] =  config('constants.passport-variables.passport_password_grant_client_id');
        $bodyGuzzle["client_secret"] = config('constants.passport-variables.passport_password_grant_client_secret');
        $bodyGuzzle["username"] = $request->email;
        $bodyGuzzle["password"] = $request->password;
        $bodyGuzzle["scope"] = '*';
        $bodyGuzzle["customProvider"] = 'usersapi';

        $guzzleRequest->body = $bodyGuzzle;

        Log::debug('GUZZLE REQUEST');
        Log::debug($guzzleRequest);

        $response = $this->guzzlePost($guzzleRequest);
        if (isset($response['access_token'])) {

            Log::debug('PASSED SUCCESSFULL RESPONSE');
            return response($response, 200);
        }else{
            return response([
                "message"=>"Unauthorized"
            ], 401);
        }
    }
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    //THE LOGIN FUNCTION DOES NOT EVEN WORK
    //NOT EVEN SURE WHY WE NEED THIS MARCO?
    public function login(Request $request)
    {
        //dump($request);
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        Log::debug('PASSES IF STATEMENT'.$request->customProvider);

        //**********************************************
           $response = Http::asForm()->post(config('app.passport_url'), [
       
            'client_id' => request('client_id'),
            'client_secret' => request('client_secret'),
            'scope' => '*',
            'username'=>request('email'),
            'password'=>request('password'),
            'grant_type' => request('grant_type')
        
    ]);
        Log::debug('ACCESS TOKEN'.$response['access_token']);

        Log::debug($response);        // $new_acess_token= json_decode($response->getContent(), true)['access_token'];

        if (isset($response['access_token'])) {
            $this->clearLoginAttempts($request);
            return response($response, 200);
        }
        Log::debug('NOT PASSED SUCCESSFULL RESPONSE');

        //**********************************************

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        
        return $this->sendFailedLoginResponse($request);
    }

    public function refreshtoken(Request $request)
    {

        $response = Http::asForm()->post(config('app.passport_url'), [
       
            'client_id' => request('client_id'),
            'client_secret' => request('client_secret'),
            'scope' => '*',
            'username'=>request('email'),
            'password'=>request('password'),
            'grant_type' => 'refresh_token'
        
    ]);
      


        return response($response, 200);
    }

    //not used for anything at all, fix this marco
    public function refresh(Request $request)
    {
        return $this->response($this->loginProxy->attemptRefresh());
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
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }



    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

 

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
