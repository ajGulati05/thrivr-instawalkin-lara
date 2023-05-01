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

class ModifyBookingController extends Controller
{

    use ReconcileUserTypeTrait;

    use TimekitTraitV2;
    use BookingTraitV2;
    
   
  


  public function splitPaymentTypes(Booking $booking, Request $request){
    $this->authorize('ownsBooking', $booking);

    if($booking->isClosed()){
      abort(response()->json(["message"=>'The booking is locked and cannot be modified',"status"=>false,"errors"=>"The booking is locked and cannot be modified."],405));
    }
     $request->validate([
        'paid_by'=>'required:payment_types,code',
        'paid_by_2'=>'sometimes:payment_types,code',
        'amount_1'=>'required|numeric',
        'amount_2'=>'sometimes|numeric|required_if:paid_by_2,true',
        'card_id'=>'required_if:payment_type,CR'
    ]);

     $bookingPricing=$booking->firstActiveBookingPricing();
    if($request->exists('paid_by_2') && $request->exists('amount_2') ){
        if((request('amount_1')+request('amount_2'))!=($booking->getBookingTotal()+$bookingPricing->tip_amount)){
             abort(response()->json(["message"=>'The amounts do not match',"status"=>false,"errors"=>"The amounts do not match."],405));

        }

    }

     $booking->update([

      "paid_by"=>request('paid_by'),
      "paid_by_2"=>request('paid_by_2')
]);

       $bookingPricing->update([
        "amount_1"=>request('amount_1'),
        "amount_2"=>request('amount_2'),
  ]);



//TODO have to create a booking_transaction for CREDIT

  $booking->fresh();
  return response()->json(['data'=>new TherapistBookingResource($booking)],200);
    
  }



public function addTip(Booking $booking, Request $request){
     

     $this->authorize('ownsBooking', $booking);

    if($booking->isClosed()){
      abort(response()->json(["message"=>'The booking is locked and cannot be modified',"status"=>false,"errors"=>"The booking is locked and cannot be modified."],405));
    }

    $request->validate([
        'tip'=>'required|numeric'
    ]);



    $booking->firstActiveBookingPricing()->update(["tip_amount"=>request('tip')]);
    $booking->fresh();

    return response()->json(['data'=>new TherapistBookingResource($booking)],200);


}







public function updateModality(Booking $booking, Request $request){
      $this->authorize('ownsBooking', $booking);

    if($booking->isClosed()){
      abort(response()->json(["message"=>'The booking is locked and cannot be modified',"status"=>false,"errors"=>"The booking is locked and cannot be modified."],405));
    }

    $request->validate([
        'managerspeciality'=>'required|numeric'
    ]);



    $booking->manager_speciality_id=request('managerspeciality');
    
    $booking->fresh();



    return response()->json(['data'=>new TherapistBookingResource($booking)],200);

}


public function delete(Booking $booking, Request $request){

     $this->authorize('ownsBooking', $booking);
    if($booking->isClosed()){
      abort(response()->json(["message"=>'The booking is locked and cannot be modified',"status"=>false,"errors"=>"The booking is locked and cannot be modified."],405));
    }


       $request->validate([
        'booking_id'=>'required:bookings,timekit_booking_id',
    ]);




       $newBooking=Booking::where('timekit_booking_id',request('booking_id'))->first();



       $booking->booking_status='D';
       $booking->parent_id=$newBooking->id;
       $booking->closed=true;
       $booking->save();


       try{
           $this->cancelBookingTimekit($booking->timekit_booking_id);
          $this->deleteBookingTimekit($booking->timekit_booking_id);
     }
     catch(Exception $ex)
     {

     }

       return response()->json(['status'=>true],200);

}




   
}
