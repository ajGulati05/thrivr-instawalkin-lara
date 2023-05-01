<?php

namespace App\Http\Controllers;
use App\Booking;
use App\CovidForm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\v2\CovidFormsTrait; 

use App\Http\Resources\UsersApi\v2\CovidFormDetailResource;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\CovidFormRequest;
class CovidFormController extends Controller
{
    use CovidFormsTrait;

    public function resolveCreateOrConsent(CovidFormRequest $request){
                    $booking=Booking::where('timekit_booking_id',request('booking'))->first();
        if(request('modifier')=='U')
                {
                    $this->createFromSignedUrl($request,$booking);
                }
         else{
        
                $oldintakeForm=CovidForm::find(request('cform'));
                $oldintakeForm->active=1;
                $oldintakeForm->consent=1;
                $newintakeForm=$oldintakeForm->create($oldintakeForm->toArray());
              Log::debug($newintakeForm);
               
            $this->consentToManager($booking,$newintakeForm);
               
         }       
return response()->json(["message"=>"Thank you","status"=>true]);
    }
 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createFromSignedUrl(CovidFormRequest $request,$booking)
    {   


if($request->has('user'))
{
   $user=request('user');
}

if($request->has('guest'))
{
    $user=request('guest');
}

if($request->has('userGuest'))
{
      $user=request('userGuest');
}


     
        $intakeform= $this->storeCovidFormWithSignedUrl($user,$request);
        return $this->consentToManager($booking,$intakeform);
    
    }



public function consentToManager($booking,$intakeform){

  
      return $this->giveConsentToBookingManagerForForm($booking,$intakeform);

}
 
  
}
