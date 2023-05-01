<?php

namespace App\Http\Traits\v2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\IntakeFormRequest;
use App\Http\Resources\UsersApi\v2\IntakeFormDetailResource;
trait IntakeFormsTrait
{
     protected $client="User:";
    protected $userGuest="UserGuest:";
    protected $guest= "Guest:";
 

    public function resolveIntakeForm(Model $booking){

        $userGuestModel=$booking->bookable;
        $userguest_id=isset($booking->userguest_id)?$booking->userguest_id:null;
        $manager=$booking->manager;
       
          //check if user has an active form 
      if($this->hasActiveIntakeForm($userGuestModel,$userguest_id))
      {
          $intakeForm=$this->getCurrentActiveIntakeForm($userGuestModel,$userguest_id);
          if($this->doesTherapistHaveConsentToIntakeForm($intakeForm,$manager))
                {

                  //its shared
                  return ["alreadyConsented"=>true,"intakeFormAPIUrl"=>$this->createConsentURL($userGuestModel,$intakeForm,$booking->manager,$booking),"intakeForm"=> new IntakeFormDetailResource($intakeForm)];
                }
            else{
                  //its not shared
              //should  return link to shre here ?
                    return ["alreadyConsented"=>false,"intakeFormAPIUrl"=>$this->createConsentURL($userGuestModel,$intakeForm,$booking->manager,$booking),"intakeForm"=> new IntakeFormDetailResource($intakeForm)];
            }

      }

      else{

             return ["alreadyConsented"=>false,"intakeFormAPIUrl"=>$this->createConsentURL($userGuestModel,null,$manager,$booking),"intakeForm"=>null];
         

      }



    }
    //check if has User or UserGuest has active intake form
    public function hasActiveIntakeForm(Model $userGuestModel,$userguest_id=null){
            return $userGuestModel
                   ->intakeforms()
                   ->where('userguest_id',$userguest_id)
                   ->active()
                   ->exists();
    }

  

    public function storeIntakeFormWithSignedUrl(Model $userGuestModel, Request $request)
    {
       
      return  $this->storeIntakeForm($userGuestModel,$request);

    }


 public function storeIntakeForm(Model $userGuestModel, IntakeFormRequest $request)
    {
      $data=[
        'name'=>request('name'),
        'active' =>request('active'),
        'address'=>request('address'),
        'phone' => request('phone'),
        'birthdate' => request('birthdate'),
        'referred_by' => request('referred_by'),
        'physician_name' => request('physician_name'),
        'allergies' => request('allergies'),
        'sports_activities' => request('sports_activities'),
        'current_medications' => request('current_medications'),
        'medical_conditions' => request('medical_conditions'),
        'care' => request('care'),
        'surgery' => request('surgery'),
        'fractures' => request('fractures'),
        'illness' => request('illness'),
        'motor_workplace' => request('motor_workplace'),
        'tests' => request('tests'),
        'relieves' => request('relieves'),
        'aggravates' => request('aggravates'),
        'consent' =>request('consent'),
        'userguest_id'=>request('ug')

      ];
   
    return $userGuestModel->intakeforms()->create($data);    

  }

    public function doesTherapistHaveConsentToIntakeForm( $form,  $manager){
      //check t

       return $manager->intakeForms()->where('intakeform_id',$form->id)->exists();
    }

      /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function createConsentURL(Model $userGuestModel,$form=null, $manager,$booking)
    {
        $id=isset($form)?$form->id:null;
         $userguest_id=isset($booking->userguest_id)?$booking->userguest_id:null;

 if($booking->bookable instanceof \App\User)

  {
    $userType= $this->client;
 
  }

  else{
     $userType=$this->guest;
  }

       
      //TODO CHANGE TIMER
        return URL::temporarySignedRoute(
            "form.intake",
            Carbon::parse($booking->start)->addMinutes(60),
            [
                'instauuid' => $userType.$userGuestModel->instauuid,
                'form'=>$id,
                'therapist_name'=>$manager->first_name." ".$manager->last_name,
                'manager'=>$manager->timekit_resource_id,
                'ug'=>$userguest_id
            ]
        );
    }


      public function getAllCurrentActiveIntakeForm(Model $userGuestModel){
        $form= $userGuestModel->intakeforms()->active()->get();
        return $form;
    }

    public function getCurrentActiveIntakeForm(Model $userGuestModel,$userguest_id=null){
        $form= $userGuestModel->intakeforms()->where('userguest_id',$userguest_id)->active()->first();
        return $form;
    }

    public function giveConsentToManagerForForm( $manager,  $intakeForm)
    {

        $intakeFormsDeactivate=$manager
        ->intakeForms
        ->where("intakeformable_id",$intakeForm->intakeformable_id)
        ->where('intakeformable_type',$intakeForm->intakeformable_type)
        ->where('userguest_id',$intakeForm->userguest_id);

        foreach($intakeFormsDeactivate as $iform){
          $iform->active=0;
          $iform->save();
        }
       // Here I have to update intake form
        $intakeFormManagerRelationship=$manager->intakeForms()->attach($intakeForm->id,['active'=>1]);
        return $intakeFormManagerRelationship;
    }
}
