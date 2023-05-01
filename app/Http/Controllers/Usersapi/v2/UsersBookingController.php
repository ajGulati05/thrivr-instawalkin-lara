<?php

namespace App\Http\Controllers\Usersapi\v2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\BookRequest;
use App\Manager;
use App\Project;
use App\Stripedata;
use App\User;
use App\ManagerSpeciality;
use App\Booking;

use Illuminate\Validation\Rule;

use App\Http\Traits\v2\BookingTraitV2;
use App\Http\Traits\v2\TimekitTraitV2;
use App\Http\Traits\v2\ModifyBookingTrait;


use Exception;
use GuzzleHttp\Exception\ClientException;
use App\Http\Resources\UsersApi\v2\BookingResource;
use Illuminate\Support\Facades\App;
use App\Http\Traits\v2\IntakeFormsTrait; 
use App\Http\Traits\v2\CovidFormsTrait; 
use App\Http\Traits\v2\FormFlowTrait; 
use App\Notifications\UserBookingNotification;
use App\Notifications\ManagerBookingNotification;
use Carbon\Carbon;
use App\Helpers\PromoCodeClass;
class UsersBookingController extends Controller
{
    use TimekitTraitV2;
    use BookingTraitV2;

    use ModifyBookingTrait;
    use IntakeFormsTrait;
    use CovidFormsTrait;
    use FormFlowTrait;

    //use NotificationsTrait;

    public function discount(){
         $user=Auth::user();

         $count=$user->books->count();

         return response()->json(["discount-valid"=>$count>0?false:true,"status"=>true]);
    }
    public function book( Project $project, Manager $manager,ManagerSpeciality $managerspeciality, Request $request)
    {
       
        
        $promoCodeHelper=new PromoCodeClass();
        $promo_code=null;
      
        //if the request has promo code apply the promo code
        if($request->exists('promo-codes')){

            $promoCodeHelper->runPromoCodeCheck(request('promo-codes'));
            $promo_code=request('promo-codes');
          
        }
    
        $user=Auth::user()->load('userprofiles');
        
        //check if a credit card is require, this means the user has not create a credit card before creating a booking 
       if($user->forceRequireCreditCard()){
            return   abort(response()->json(["message"=>"Credit card needed.","status"=>false],400));
       }
        //TODO better way to do this
     
       
      
    //get card id requied for booking can be null if paying by cash 
         //TODO assure the use can use this card
        $card=null;

        $paid_by=$request->paid_by;
        if(!empty($request->card_id))
        {
            $card=Stripedata::find($request->card_id);
             $paid_by=$request->paid_by;
        }
        $projectDetail = $project->load('activeprojectpricing.calculatetax');

        //create the booking requests to send to timekit
        $bookRequest=$this->createBookingRequest($manager,$user,$request,$projectDetail,$managerspeciality);
      
        //aka user made the appoinment
        $by_source = 'USERS';


     
      
        //make the booking
        return $this->makeBooking($bookRequest,$user,$projectDetail,$card,$promo_code,$paid_by);
        //CREATING REQUEST FOR TIMEKIT BOOKING
        

        // thats how you save a polymorphic relationship
        //$user->books()->save($booking);

    }
    

    //this function creates the booking payload to send to timekit
public function createBookingRequest($manager,$user,$request,$project,$managerspeciality){

        $start = $request->start;
        $end = $request->end;
        $what = $project->name; 
        if($manager->calendar_sync){

       


        $end =     Carbon::parse($request->end,$manager->timezone)->addMinutes(15)
->toAtomString();
 $what = $project->name . " + 15 mins buffer"; 
        }

       //make query of the project title
        $where='Thrivr Client at '  . $manager->business_name;//$user->profiles->firstname.' '.$user->profiles->lastname . ' at ' . $manager->business_name;
        $description = $project->description;
        $bookRequest = new BookRequest();
        $bookRequest->timekit_resource_id = $manager->timekit_resource_id;
        $bookRequest->graph =config('constants.configurations.booking_graph');
        $bookRequest->customer_id = $user->id;
        $bookRequest->customer_name =$user->profiles->firstname.' '.$user->profiles->lastname;
        $bookRequest->customer_email = $user->email;
               
 if (!App::environment(['production'])) { 
   
   //Timekit Test does not let booking happen with anything other than different email and user 
        $bookRequest->customer_id= Auth::user()->id;
         $bookRequest->customer_name = config('constants.configurations.booking_customer_name');
         $bookRequest->customer_email= config('constants.configurations.booking_customer_email'); 
}
        $bookRequest->start = $start;
        $bookRequest->end = $end;
        $bookRequest->what = $what;
        $bookRequest->where = $where;
        $bookRequest->description = $description;
        $bookRequest->manager_id = $manager->id;
        $bookRequest->project_id = $project->id;
        $bookRequest->app_source = $request->app_source;
        $bookRequest->paid_by = $request->paid_by;
        $bookRequest->by_source = 'USERS';
        $bookRequest->timezone= $manager->timezone;
         $bookRequest->userTimezone= $request->userTimezone;
        $bookRequest->manager_speciality_id = $managerspeciality->id;
        $bookRequest->project_pricing_id = $project->activeprojectpricing[0]->id;
        return $bookRequest;
}



//this request processes the booking 
//sends to timekit
//on booking success creates the records on DB
public function makeBooking($bookRequest,User $user,$project,$card,$promo_code,$paid_by){
     $bookError = null;
        try {

               $responseBooking = $this->bookTimekit($bookRequest);
                $timekit_booking_id = $responseBooking['data']['id'];
               // $timekit_booking_id='xs';
                $bookRequest->timekit_booking_id=$timekit_booking_id;
                $saveBooking = $this->createBookingOnDatabase($bookRequest);
                $booking=$user->books()->save($saveBooking);

                $bookingPricingToSave=$this->createBookingPricingOnDatabase($project,$promo_code);
                $bookingPricing=$booking->booking_pricings()->save($bookingPricingToSave);

                      try{
                $booking->bookable->notify(new UserBookingNotification($booking));
                $booking->manager->notify(new ManagerBookingNotification($booking));
            }
               catch(\Exception $e){ // Using a generic exception
                Log::critical('User Booking notification error makeBooking'.$booking->id .$e);
            }
                if ($paid_by == Booking::PAID_BY_CREDIT_CARD) {
                        
                            $this->createBookingTransactionOnDatabase($bookingPricing,$card->id);

                        } 

          
           
        $booking=$saveBooking->load('manager.profiles','managerSpeciality','activeBookingPricing.topActiveBookingTransaction.stripedatas','userGuests');
      
 $intakeForm=$this->resolveIntakeForm($booking);
     $covidForm=$this->resolveCovidForm($booking);
        
            return response()->json(["data"=>["booking"=>new BookingResource($booking),"intake-form"=>$intakeForm,"covid-form"=>$covidForm],"status"=>true],200);
        } catch (ClientException $exception) {
                   abort(response()->json(["status"=>false,"errors"=>"We could not complete your booking, we are looking into the issue","message"=>"We could not complete your booking, we are looking into the issue"],422));
        }
}


public function copyBooking(Request $request,Booking $booking){

    $cardData=$booking->load('activeBookingPricing.topActiveBookingTransaction');
     if ($booking->paid_by == Booking::PAID_BY_CREDIT_CARD) {
                $card_id=$cardData->activeBookingPricing[0]->topActiveBookingTransaction[0]->stripedatas_id;
                $request->merge(['card_id'=>$card_id]);
}
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
            'card_id'=>'sometimes|nullable',
        ]);


 if (! $request->hasValidSignature()) {
        abort(response()->json(["message"=>"Request forbidden","errors"=>"Request forbidden","status"=>false],403));
    }
  
  $newBooking=null;
    if(request('modifier')=='R')
    {
        $newBooking=$this->copyBooking( $request, $booking);
    }

    $amountToBeCharged=request('amount_to_be_charged');
    Log::debug($amountToBeCharged);
    if($amountToBeCharged!="0")
    {
    Log::critical("Please charge {$amountToBeCharged} to {$booking->bookable->email}");
    }

    $response= $this->confirmModifyBooking($request,$booking,'USER');
    $intakeForm=$this->intakeForms($booking);
     $covidForm=$this->resolveCovidForm($booking);
  return response()->json(["data"=>["modifiedBooking"=>new BookingResource($response),"newBooking"=>$newBooking,"intake-form"=>$intakeForm,"covid-form"=>$covidForm],"status"=>true],200);

}


public function modify(Request $request,Booking $booking){


          
         $request->validate([
            'modifier' => ['required',Rule::in(['R','C'])]
           
        ]);

    if($this->authorize('doesTheUserOwnTheBooking',$booking) && $this->authorize('isStartTimeNotStarted',$booking) ){
         
          $response= $this->modifyBooking($request,$booking,'USER');


            $signeModifyUrl=URL::temporarySignedRoute(
    'modify.confirm', 
    now()->addMinutes(65),
    ['booking' =>$booking,'amount_to_be_charged'=>$response["amount-to-be-charged"],
    'modifier'=>request('modifier')
]);


  
 return response()->json(["message"=>$response["message"],"callback-url"=>$signeModifyUrl,"therapist_slug"=>$booking->manager->slug,"status"=>true],200);
}
    }
 

public function emailIntakeForms(Booking $booking){
    return response()->json(["url"=>$this->createEmailFormFlowURL($booking)]);
}

 public function intakeForms(Booking $booking){

           
        return response()->json($this->resolveIntakeForm($booking));

 }   

 public function covidForms(Booking $booking){

    
        return response()->json($this->resolveCovidForm($booking));

 }  

   
}
