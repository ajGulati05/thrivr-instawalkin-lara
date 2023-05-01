<?php

namespace App\Http\Traits\v2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\UsersApi\v2\CovidFormDetailResource;

trait CovidFormsTrait
{
  protected $client="User:";
    protected $userGuest="UserGuest:";
    protected $guest= "Guest:";

  

    public function resolveCovidForm(Model $booking){

        $userGuestModel=$booking->bookable;
        $userguest_id=isset($booking->userguest_id)?$booking->userguest_id:null;
          //check if user has an active form 
      if($this->hasActiveCovidForm($userGuestModel,$userguest_id))
      {
          $covidForm=$this->getCurrentActiveCovidForm($userGuestModel,$userguest_id);
          $callback_url=$this->createCovidConsentURL($userGuestModel,$covidForm,$booking->manager,$booking);
          return ["covidFormAPIUrl"=>$callback_url,"covid_form"=> new CovidFormDetailResource($covidForm)];
            }

      else{

            $callback_url= $this->createCovidConsentURL($userGuestModel,null,$booking->manager,$booking);
            return ["covidFormAPIUrl"=>$callback_url,"covid_form"=>null];

      }



    }
    //check if has User or UserGuest has active intake form
    public function hasActiveCovidForm(Model $userGuestModel,$userguest_id=null){
            return $userGuestModel
                   ->covidforms()
                   ->where('userguest_id',$userguest_id)
                   ->active()
                   ->exists();
    }

  

    public function storeCovidFormWithSignedUrl(Model $userGuestModel, Request $request)
    {

   
      return $this->storeCovidForm($userGuestModel,$request);
    }


 public function storeCovidForm(Model $userGuestModel, Request $request)
    {
$data=[

    'active' =>request('active') ,
        'testing' => request('testing'),
        'name' => request('name'),
        'symptoms' => request('symptoms'),
        'exposure' => request('exposure'),
        'travel' => request('travel'),
        'precautions' => request('precautions'),
        'contact' => request('contact'),
        'actions' => request('actions'),
        'consent' =>request('consent'),
        'userguest_id'=>request('ug')

      ];
   
    return $userGuestModel->covidforms()->create($data);    



    

    }

    public function doesBookingManagerHaveConsentToCovidForm( $form,  $manager){
      //check t
 
       return $booking->covidForms()->where('covidform_id',$form->id)->exists();
    }

      /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function createCovidConsentURL(Model $userGuestModel,$form=null, $manager,$booking)
    {
         $userguest_id=isset($booking->userguest_id)?$booking->userguest_id:null;
        $id=isset($form)?$form->id:null;
         if($booking->bookable instanceof \App\User)

  {
    $userType= $this->client;
 
  }

  else{
     $userType=$this->guest;
  }
      //TODO add User:, Guest: Client
        return URL::temporarySignedRoute(
            "cform.intake",
            Carbon::parse($booking->start)->addMinutes(60),
            [
                'instauuid' => $userType.$userGuestModel->instauuid,
                'cform'=>$id,
                'therapist_name'=>$manager->first_name." ".$manager->last_name,
                'booking'=>$booking->timekit_booking_id
            ]
        );
    }


    public function getCurrentActiveCovidForm(Model $userGuestModel,$userguest_id=null){
        $form= $userGuestModel->covidforms()->where('userguest_id',$userguest_id)->active()->first();
        return $form;
    }

    public function giveConsentToBookingManagerForForm(Model $booking, Model $covidForm)
    {
        $covidFormBookingManagerRelationship=$booking->covidForms()->attach($covidForm->id,['active'=>1]);
        return $covidFormBookingManagerRelationship;
    }
}
