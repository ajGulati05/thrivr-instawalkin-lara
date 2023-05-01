<?php

namespace App\Http\Controllers\Managersapi\Clients;

use App\Http\Traits\v2\ReconcileUserTypeTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Guest;
use App\Http\Resources\TherapistApi\v2\TherapistGuestResource;
use App\Http\Resources\TherapistApi\v2\TherapistClientResource;
use Illuminate\Support\Facades\Validator;
use App\Booking;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\PhoneMaskerClass;
use App\Http\Requests\CreateGuestRequest;
use App\Http\Traits\v2\GuestTrait;
use Illuminate\Http\JsonResponse;

use App\Http\Traits\v2\MergeGuestToUserTrait;

class GuestController extends Controller
{
    use ReconcileUserTypeTrait;
  use GuestTrait;

use MergeGuestToUserTrait;
   public function resendEmail(Request $request){
       $guest=$this->reconcileUser($request);
        return $this->sendVerificationEmail($guest);

   }

  public function sendVerificationEmail(Guest $guest){


      if ($guest->hasVerifiedEmail()) {
        return  new JsonResponse(['status' => true, "data" =>[ "client"=>new TherapistClientResource($guest->user)]], 200);
      }

      //TODO maybe its a guest.
        $this->doesEmailExistsInUsers($guest)?
            $guest->sendEmailAcceptanceNotification()
            :$guest->sendEmailVerificationNotification();

    return  new JsonResponse(['status'=>true,'message'=>"A verification email has been sent to the guest"], 200);
  }

    public function store(CreateGuestRequest $request){
        $manager=Auth::user();
     
         $phone=PhoneMaskerClass::removeMask(request('phone'));
        $guest=$manager->guests()->create([
            'firstname'=>request('firstname'),
            'lastname'=>request('lastname'),
            'email'=>request('email'),
            'phone'=> $phone,
            'instauuid'=>(string) Str::orderedUuid()
        ]);

        if(request('verify')==1){
            $this->sendVerificationEmail($guest);
        }

        return response()->json(["data"=>new TherapistGuestResource($guest),"status"=>true]);
    }   

    public function update(CreateGuestRequest $request, Guest $guest){

        
       if($this->authorize('update',$guest)){     
       

 
        $phone=PhoneMaskerClass::removeMask(request('phone'));
       
       
        $guest->update([
            'firstname'=>request('firstname'),
            'lastname'=>request('lastname'),
            'email'=>request('email'),
            'phone'=> $phone
        ]);

            if(request('verify')==1 ){
            $this->sendVerificationEmail($guest);
            }

        return response()->json(["data"=>new TherapistGuestResource($guest->fresh()),"status"=>true]);
        }
    }  



public function test(){
        $guest=Guest::find(19);
        $this->onVerification($guest);

}

}