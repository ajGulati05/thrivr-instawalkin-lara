<?php

namespace App\Http\Controllers\Usersapi\v2;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
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
        $this->middleware('guest:usersapi');
         
   ResetPassword::toMailUsing(function ($notifiable, $token) {
    $url = $token;
            return (new MailMessage)
                ->subject(__('Reset Password Notification'))
                ->line(__('You are receiving this email because we received a password reset request for your account.'))
                ->action(__('Reset Password'),  $url )
                ->line(__('If you did not request a password reset, no further action is required.'));
        });
     
    }
  /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('users');
    }
      protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(["message"=>trans($response,['email'=>request('email')]),'status'=>true],200);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
     return response()->json(["errors"=>trans($response,['email'=>request('email')]),'status'=>false],200);
    }
}
