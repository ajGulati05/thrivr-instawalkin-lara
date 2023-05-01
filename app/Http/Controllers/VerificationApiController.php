<?php
namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class VerificationApiController extends Controller
{

    use VerifiesEmails;

  

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

        $user=User::find($request->route('id'));
        //Get User
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse(['status'=>true,'message'=>"You are already verified"], 200)
                        : redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse(['status'=>true,'message'=>"You are now verified"], 200)
                    : redirect($this->redirectPath())->with('verified', true);
    }

 /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {

      
        $user=Auth::user();
        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse(['status'=>true,'message'=>"You are already verified"], 200)
                        : redirect($this->redirectPath());
        }

        $user->sendEmailVerificationNotification();

        return $request->wantsJson()
                    ? new JsonResponse(['status'=>true,'message'=>"A verification email has been sent to you"], 200)
                    : back()->with('resent', true);
    }

    }