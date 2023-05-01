<?php

namespace App\Http\Controllers\Dev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use App\User;
use App\Booking;
use App\Notifications\ReferralUpdateNotification;
//This controller is not only for testing/running schedulers certain routes in dev and staging
class DevController extends Controller
{

public function sendProductUpdate(){
    //$user=User::first();
    //$user->notify(new ReferralUpdateNotification());

    $user=User::latest()->first();
    $user->notify(new ReferralUpdateNotification());
    return "suucess";
    //return $user->email;
}

public function updateEmailToNull(User $user){
    $user->email=null;
    $user->save();

   return "Success";
   }


 public function updatePhoneToNull(User $user){
     $user->profiles->phone=null;
    $user->profiles->save();
      return "Success";
   }


 public function updateEmailPhoneToNull(User $user){
        $this->updatePhoneToNull($user);
        $this->updateEmailToNull($user);
        return "Success";

   }


    public function toggleBookingClose(Booking $booking){
    $booking->closed=!$booking->closed;
    $booking->save();
    }

}
