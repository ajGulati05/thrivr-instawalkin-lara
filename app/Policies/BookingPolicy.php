<?php

namespace App\Policies;
use Illuminate\Auth\Access\Response;
use App\User;
use App\Manager;
use App\Booking;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class BookingPolicy
{
    use HandlesAuthorization;
 

 public function canTipBeAddedBetweenDates(User $user,Booking $booking)
    {
        //TODO CHECK IF THE CARD WAS USED FOR A RECENT MASSAGE AND HAS NOT BEEN CHARGED YET
        $today=Carbon::now();
        $todayAdd5=$today->add(5, 'day');
        return $today->between( new Carbon($booking->start),$todayAdd5)
         ? Response::allow()
                :abort(response()->json(["message"=>'You can only add tip within 5 days after the massage date.',"status"=>false,"errors"=>"You can only add tip within 5 days after the massage date."],403));
    }


 public function tipCanOnlyBeAddedIfOneDoesNotExist(User $user,Booking $booking)
    {
   
        return empty($booking->firstActiveBookingPricing()->tip_amount)
         ? Response::allow()
                :abort(response()->json(["message"=>'A tip already exists, for this appointment.',"status"=>false,"errors"=>"A tip already exists, for this appointment."],403));
    }
 public function doesTheUserOwnTheBooking(User $user,Booking $booking)
    {
        //TODO check if bookapble type is users type
        return $user->id==$booking->bookable_id
         ? Response::allow()
                :abort(response()->json(["message"=>'Sorry, this booking is not yours.',"status"=>false,"errors"=>"Sorry, this booking is not yours."],403));
    }
public function isStartTimeDone(User $user,Booking $booking){
     $today=Carbon::now();
     return $today->isAfter( new Carbon($booking->end))
         ? Response::allow()
                :abort(response()->json(["message"=>'The receipt is only available after the appointment',"status"=>false,"errors"=>"The receipt is only available after the appointment."],403));
}


public function isStartTimeNotStarted(User $user,Booking $booking){
     $today=Carbon::now();
     return $today->isBefore(new Carbon($booking->start))
         ? Response::allow()
                :abort(response()->json(["message"=>'The booking can no longer be modifed',"status"=>false,"errors"=>"The booking can no longer be modifed."],403));
}

 public function ownsBooking(Manager $manager,Booking $booking)
    {
        //TODO CHECK IF THE CARD WAS USED FOR A RECENT MASSAGE AND HAS NOT BEEN CHARGED YET
 
        return $manager->id===$booking->manager_id
         ? Response::allow()
                :abort(response()->json(["message"=>'You do not own this booking.',"status"=>false,"errors"=>"You do not own this booking."],403));
    }

}
