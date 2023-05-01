<?php
namespace App\Http\Controllers\Managersapi\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\URL;
use App\Http\Requests\BookRequest;
use App\Manager;
use App\Project;
use App\Guest;
use App\ManagerSpeciality;
use App\Booking;
use Illuminate\Validation\Rule;
use App\Http\Traits\v2\BookingTraitV2;
use App\Http\Traits\v2\TimekitTraitV2;
use App\Http\Traits\v2\ModifyBookingTrait;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Exception\ClientException;
use App\Http\Resources\TherapistApi\v2\TherapistBookingResource;
use Illuminate\Support\Facades\App;
use App\Notifications\UserBookingNotification;
use App\Notifications\ManagerBookingNotification;
use App\Stripedata;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\v2\ReconcileUserTypeTrait;
class ManagerBookingController extends Controller
{

    use ReconcileUserTypeTrait;

    use TimekitTraitV2;
    use BookingTraitV2;
    
    use ModifyBookingTrait;
    //use NotificationsTrait;

    public function book(Project $project ,ManagerSpeciality $managerspeciality,Request $request)
    {

              $client= $this->reconcileUser($request);
          $request->validate([
            'app_source' => 'required',
            'start' => 'required|date|after_or_equal:'.Carbon::now(),
            'end' => 'required|date|after_or_equal:start',
            'paid_by' => 'required|string',
            'sub_modalities'=>  'sometimes|string',
            'card_id'=>Rule::requiredIf(request('paid_by')==Booking::PAID_BY_CREDIT_CARD)
        

        ]);
        
       
        $manager=Auth::user();
       
       

        $card=null;
             if(!empty($request->card_id))
        {
            $card=Stripedata::find($request->card_id);
             $paid_by=$request->paid_by;
        }
        $paid_by=request('paid_by');
        $projectDetail = $project->load('activeprojectpricing.calculatetax');
        $bookRequest=$this->createBookingRequest($manager,$client,$request,$projectDetail,$managerspeciality,$paid_by);
        //aka user made the appoinment
        $by_source = 'MANAGER';

        return $this->makeBooking($bookRequest,$client,$projectDetail,$card,null,$paid_by,$request);
        //CREATING REQUEST FOR TIMEKIT BOOKING
        

        // thats how you save a polymorphic relationship
        //$user->books()->save($booking);

    }


   public function makeBooking($bookRequest, $client,$project,$card,$coupon_amount,$paid_by,$request){
     $bookError = null;
        try {
                // check if the manager is trying to modify or create a booking
                // #TODO create separate functions for creating and modifying bookings.
                $isModifying =$request->modifying?true:false;
                $responseBooking = $this->bookTimekit($bookRequest,$isModifying);

                $timekit_booking_id = $responseBooking['data']['id'];
                $bookRequest->timekit_booking_id=$timekit_booking_id;
                $saveBooking = $this->createBookingOnDatabase($bookRequest);
                $booking=$client->books()->save($saveBooking);

                $bookingPricingToSave=$this->createBookingPricingOnDatabase($project,null);
                $bookingPricing=$booking->booking_pricings()->save($bookingPricingToSave);

                if($request->exists('sub_modalities'))
                {


                    $bookingAddOn=$this->createBookingAddOns($booking, $request->sub_modalities);
                }

               
                try{
                $booking->bookable->notify(new UserBookingNotification($booking));
                $booking->manager->notify(new ManagerBookingNotification($booking));
            }
               catch(\Exception $e){ // Using a generic exception
                Log::critical('Manager Booking notification error'.$booking->id .$e);
            }


          if ($paid_by == Booking::PAID_BY_CREDIT_CARD) {
                        
                            $this->createBookingTransactionOnDatabase($bookingPricing,$card->id);

                        } 
           
        $booking=$saveBooking->load('manager.profiles','managerSpeciality','activeBookingPricing.topActiveBookingTransaction.stripedatas','userGuests');
      
 
        
            return response()->json(["data"=>new TherapistBookingResource($booking),"status"=>true],200);
        } catch (ClientException $exception) {
                   abort(response()->json(["status"=>false,"errors"=>"We could not complete your booking, we are looking into the issue","message"=>"We could not complete your booking, we are looking into the issue"],422));
        }
} 


    
public function createBookingRequest($manager,$client,$request,$project,$managerspeciality,$paid_by='CA'){

        $start = $request->start;

        $end = $request->end;
        $what = $project->name; //make query of the project title
        $description = $project->description;
        $bookRequest = new BookRequest();
        $bookRequest->timekit_resource_id = $manager->timekit_resource_id;
        $bookRequest->graph =config('constants.configurations.booking_graph');
        $bookRequest->customer_id = $client->id;
        $bookRequest->customer_name =$client->fullName;
        $bookRequest->customer_email = $client->email;
               
 if (!App::environment(['production'])) { 
   
   //Timekit Test does not let booking happen with anything other than different email and user 
         $bookRequest->customer_id= $client->id;
 
         $bookRequest->customer_email= config('constants.configurations.booking_customer_email'); 
}

        $bookRequest->start = $start;
        $bookRequest->end = $end;
        $bookRequest->what = $what;
        $bookRequest->where = 'TBD';
        $bookRequest->description = $description;
        $bookRequest->manager_id = $manager->id;
        $bookRequest->project_id = $project->id;
        $bookRequest->app_source = request('app_source');//$request->app_source;
        $bookRequest->paid_by = $paid_by;//$request->paid_by;
        $bookRequest->by_source = 'MANAGER';
        $bookRequest->timezone= $manager->timezone;
        $bookRequest->userTimezone= $manager->timezone;
        $bookRequest->manager_speciality_id = $managerspeciality->id;
        $bookRequest->project_pricing_id = $project->activeprojectpricing[0]->id;
        return $bookRequest;
}


 




//For Modifying a booking

public function copyBooking(Request $request,Booking $booking){


    $request->merge(['paid_by' => $booking->paid_by]);

    $request->merge(['app_source' => $booking->app_source]);
    $request->merge(['userTimezone' => 'not sure']);

    Log::debug($request);
  
    $newBookingResponse=$this->book($booking->project,$booking->manager,$booking->managerSpeciality,$request);

    if($newBookingResponse->getData()->status==0){
        abort(response()->json(["message"=>"There has been an issue in your booking, we are looking into it.","errors"=>"There has been an issue in your booking, we are looking into it.","status"=>false],400));
    }

    return $newBookingResponse->getData()->data;

}
public function confirmModify(Request $request,Booking $booking){
 $request->validate([
            'start' => 'sometimes|nullable',
            'end'=>'sometimes|nullable',
            'card_id'=>'sometimes|nullable'
        ]);


 if (! $request->hasValidSignature()) {
        abort(response()->json(["message"=>"Request forbidden","errors"=>"Request forbidden","status"=>false],403));
    }
  
  $newBooking=null;
if(request('modifier')=='R')
{
    $newBooking=$this->copyBooking( $request, $booking);
}
    $response= $this->confirmModifyBooking($request,$booking,'MANAGER');

  return response()->json(["data"=>["modifiedBooking"=>new TherapistBookingResource($response),"newBooking"=>$newBooking],"status"=>true],200);

}


public function modify(Request $request,Booking $booking){


          
         $request->validate([
            'modifier' => ['required',Rule::in(['R','C'])]
           
        ]);

  //  if($this->authorize('isStartTimeNotStarted',$booking) ){
         
          $response= $this->modifyBooking($request,$booking,'MANAGER');


    $signeModifyUrl=URL::temporarySignedRoute(
    'modify.confirm.therapist', 
    now()->addMinutes(65),
   ['booking' =>$booking,
    'modifier'=>request('modifier')
]);


  
 return response()->json(["message"=>$response["message"],"callback-url"=>$signeModifyUrl,"status"=>true],200);
//     }
    }
 

  






   
}
