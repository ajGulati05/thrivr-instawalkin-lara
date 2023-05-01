<?php

namespace App\Http\Controllers\UserAuthMobile;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest');
    }


      public function sendResetLinkEmail(Request $request)
    {
               Log::error(' sendResetLinkEmail55 expired handle3');
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

      return $response == Password::RESET_LINK_SENT
                  ?  response()->json([
                'code' => '400',
                'error'=>true,
                'title'=>'Success',
                'show'=>true,
                'message' => 'We have sent you an email at '.$request->email.'. You wil get the email shortly if not please check your SPAM folder.'
            ],200)
                :  response()->json([
                'code' => '400',
                 'error'=>false,
                  'title'=>'Oops',
                'show'=>true,
                'message' => 'We cannot find the email on our side'
            ],200);
    }
}
