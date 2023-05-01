<?php

namespace App\Http\Traits\v2;
use App\Booking;
trait PersonalizeTrait
{


//This trait will be use to normalize User, Guest, Userguest models to have similar attributes that will ebe used in notifications

public function getClientFirstName(Booking $booking){
       

          if($booking->hasUserGuest()){
                return $booking->userGuests->firstNameValue;
        }

        return $booking->bookable->firstNameValue;
}

public function getClientFullName(Booking $booking){
       
       
          if($booking->hasUserGuest()){
            return $booking->userGuests->fullname;
        }

       return $booking->bookable->fullname;
}

public function getTherapistFirstName(Booking $booking){
            return $booking->manager->first_name;
    }

public function getTherapistFullName(Booking $booking){
            return $booking->manager->fullName;
    }






}
