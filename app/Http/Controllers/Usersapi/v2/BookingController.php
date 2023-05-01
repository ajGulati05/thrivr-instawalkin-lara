<?php

namespace App\Http\Controllers\Usersapi\v2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Booking;
use App\Receipt;
use App\Notifications\ReceiptNotification;
use App\Http\Resources\UsersApi\v2\BookingResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Traits\v2\StripeTraitV2;
use App\Http\Traits\v2\IntakeFormsTrait;
use App\Http\Traits\v2\CovidFormsTrait;
class BookingController extends Controller
{
   use IntakeFormsTrait;
    use CovidFormsTrait;
  use StripeTraitV2;
    public function list( )
    {
       $user=Auth::user();

        $userBooks=$user->load('books','books.manager.profiles','books.managerSpeciality','books.userGuests','books.activeBookingPricing.topActiveBookingTransaction.stripedatas');
       

        return response()->json(["data"=>BookingResource::collection($userBooks->books)->sortByDesc('start')->values()->all(),"status"=>true],200);
     }

   public function tip(Request $request, Booking $booking )
    {


    	 if ($this->authorize('canUse', $booking->getCreditCard()->stripedatas()->first())) {
        if($this->authorize('canTipBeAddedBetweenDates',$booking)&& $this->authorize('tipCanOnlyBeAddedIfOneDoesNotExist',$booking))

{

         $request->validate([
            'tip_amount' => 'required|numeric',
            
        ]);
         $booking->firstActiveBookingPricing()->update(["tip_amount"=>$request->tip_amount]);
         $fullBooking=$booking->load('manager.profiles','activeBookingPricing.topActiveBookingTransaction.stripedatas');
//old <code>
         $this->_postCreditCharges($booking,true);
    //new code         
        return response()->json(["data"=>new BookingResource($fullBooking),"status"=>true],200);
   			}
   		}
     }

public function receipt(Booking $booking){
    if($this->authorize('doesTheUserHaveAnEmail',Auth::user())){
        if($this->authorize('doesTheUserOwnTheBooking',$booking)&& $this->authorize('isStartTimeDone',$booking) ){

            try {
                $receipt = Receipt::create([
                    "booking_id" => $booking->id,
                    "request_date" =>Carbon::now(),
                    "requested_by" => 'User',
                    "requested_by_id" => Auth::id(),
                    "duplicated" => Receipt::where('booking_id',$booking->id)->exists()
                ]);
            
                // Perform notificaton
                //Log::debug('Auth::user() '. Auth::user());
                Auth::user()->notify(new ReceiptNotification($receipt));
                return response()->json(["message"=>"We have sent an email to you. Please check your spam folder, if you do not get it","status"=>true],200);
            }
            catch(\Exception $e){ 
                Log::critical('Receipt notification not sent Receipt ID'.$receipt->id); // set to critical
                Log::debug('Exception: ' . $e);
            }

        }
    }
}


public function detail(Booking $booking){

   $intakeForm=null;
     $covidForm=null;
   $detailedBooking=$booking->load('manager.profiles','managerSpeciality','activeBookingPricing.topActiveBookingTransaction.stripedatas','userGuests');
    
 if(!$booking->hasEnded()){
 $intakeForm= $this->resolveIntakeForm($booking);
 $covidForm= $this->resolveCovidForm($booking);
}
   return response()->json(["data"=>new BookingResource($detailedBooking),"intake-form"=>$intakeForm,"covid-form"=>$covidForm,"status"=>true],200);
}

}