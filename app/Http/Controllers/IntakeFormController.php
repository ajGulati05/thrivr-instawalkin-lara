<?php

namespace App\Http\Controllers;
use App\Manager;
use App\IntakeForm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\v2\IntakeFormsTrait; 
use App\Http\Resources\UsersApi\v2\IntakeFormResource;
use App\Http\Resources\UsersApi\v2\IntakeFormDetailResource;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\IntakeFormRequest;
class IntakeFormController extends Controller
{
    use IntakeFormsTrait;

    public function resolveCreateOrConsent(IntakeFormRequest $request){

        if(request('modifier')=='U')
                {
                    $this->createFromSignedUrl($request);
                }
         else{
                $manager=Manager::where('timekit_resource_id',request('manager'))->first();
                $intakeForm=IntakeForm::find(request('form'));
                 $this->consentToManager($manager,$intakeForm);
               
         }       
return response()->json(["message"=>"Thank you","status"=>true]);
    }
 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createFromSignedUrl(IntakeFormRequest $request)
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


        $manager=Manager::where('timekit_resource_id', request('manager'))->first();
        $intakeform= $this->storeIntakeFormWithSignedUrl($user,$request);
        return $this->consentToManager($manager,$intakeform);
    
    }



public function consentToManager($manager,$intakeform){

    
      return $this->giveConsentToManagerForForm($manager,$intakeform);

}
 
  
}
