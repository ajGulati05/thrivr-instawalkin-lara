<?php

namespace App\Http\Controllers\Managersapi\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Booking;
use App\Http\Resources\CommonResources\v2\IntakeFormUnEncryptedDetailResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Traits\v2\ReconcileUserTypeTrait;
use App\Http\Traits\v2\BookingTraitV2;
use App\User;
use App\Guest;
use App\UserGuest;
use App\Http\Resources\CommonResources\v2\CovidFormUnEncryptedDetailResource;
use App\Notifications\IntakeFormReminderNotification;
use Carbon\Carbon;
class IntakeFormController extends Controller
{ use ReconcileUserTypeTrait, BookingTraitV2;
    public function list(Request $request){

    	$manager=Auth::user();
        $client= $this->reconcileUser($request);
  $covidForm=["form"=>null,"booking-date"=>null];
    	

    	
if($client instanceof User)
{
    $intakeForms= $manager->userIntakeForms->where('intakeformable_id',$client->id)->whereNull('userguest_id');
}





else if($client instanceof Guest)
{
  $intakeForms= $manager->guestIntakeForms->where('intakeformable_id',$client->id);
}

else if($client instanceof UserGuest)
{
   $intakeForms= $manager->userIntakeForms->where('userguest_id',$client->id);
}



    
    $nextBooking=$this->nextBooking($client);
    if(isset($nextBooking))
    {

    
        $latestCovidForm=$nextBooking->latestCovidForm;
       if(isset($latesCovidForm)){
         $latestCovidForm=new CovidFormUnEncryptedDetailResource($latestCovidForm);
       }
      $date=Carbon::parse($nextBooking->start, 'UTC')->setTimezone($manager->timezone)->isoFormat('MMM Do, h:mm a');


       $covidForm=["form"=>$latestCovidForm,"booking-date"=>$date];
      

             }
 

  
      $collectionToReturn=IntakeFormUnEncryptedDetailResource::collection($intakeForms);
        return response()->json(["data"=>["intakeform"=>$collectionToReturn,"covid-form"=>$covidForm],"status"=>true],200)
        ->header('x-total-count',$intakeForms->count());
           
    }


    public function email(Request $request){
       $client= $this->reconcileUser($request);
      $nextBooking=$this->nextBooking($client);

       if(isset($nextBooking))
    {


           try{
                $nextBooking->bookable->notify(new IntakeFormReminderNotification($nextBooking));
              //  $booking->manager->notify(new ManagerBookingNotification($booking));
            }
               catch(\Exception $e){ // Using a generic exception
                 Log::critical('Sending intakeform error'.$nextBooking);
                return abort(response()->json(["message"=>'an error has occured',"status"=>true,'error'=>'an error has occured.'],200));
               
            }
             return response()->json(["status"=>true,"message"=>"Email has been sent"]);
}

else{
  return abort(response()->json(["message"=>'Intake form emails can only be sent within 24hours of the appointment',"status"=>true,'error'=>'Intake form emails can only be sent within 24hours of the appointment.'],200));
}

           
    }   



    

}



// Booking route you are sending back 
// $bookings =$manager->bookingsBetweenDate($start,$end)->load('managerSpeciality','bookable','userGuests');