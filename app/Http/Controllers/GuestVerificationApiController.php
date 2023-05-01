<?php
namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use App\Guest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\v2\MergeGuestToUserTrait;
use App\Http\Traits\v2\GuestTrait;
class GuestVerificationApiController extends Controller
{

    use VerifiesEmails;
    use MergeGuestToUserTrait;
    use GuestTrait;

    //


   

    public function accept(Request $request)
    {

        $guest=Guest::find($request->route('id'));
        $user=$this->getUserForEmail($guest);
        //Get User
        if (! hash_equals((string) $request->route('id'), (string) $guest->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($guest->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($guest->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse(['status'=>true,'message'=>"You are already verified"], 200)
                : redirect($this->redirectPath());
        }

        if ($guest->markEmailAsVerified()) {
            event(new Verified($guest));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        $guest->user_id=$user->id;
        $guest->save();
        $this->onAcceptance($guest);
        return $request->wantsJson()
            ? new JsonResponse(['status'=>true,'message'=>"You are now verified"], 200)
            : redirect($this->redirectPath())->with('verified', true);
    }









}