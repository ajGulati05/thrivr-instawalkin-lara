<?php

namespace App\Http\Traits;

use App\Booking;
use App\Guest;
use App\Manager;
use App\Notifications\BookingErrorToUserNotification;
use App\Notifications\CancelBookingToTherapistNotification;
use App\Notifications\CancelBookingToUserNotification;
use App\Notifications\CreditCardErrorToUserNotification;
use App\Notifications\RescheduleBookingToTherapistNotification;
use App\Notifications\RescheduleBookingToUserNotification;
use App\Notifications\SendBookSuccessToTherapistNotification;
use App\Notifications\SendBookSuccessToUserNotification;
use App\Notifications\SendReceipts;
use App\UnsubscribeTrack;
use App\User;
use Fico7489\Laravel\Pivot\Traits\FiresPivotEventsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Notification;

use App\ManagerNotifications;
use App\Http\Resources\GetBookingInfoForNotficationsResource;
trait NotificationsTrait
{
   
    public function sentNotificationToUser(Request $request)
    {
        
    }
    public function sentNotificationToTherapist(Request $request)
    {
  
    }

    public function sentExceptionNotificationToSupport(Request $request)
    {
     
    }


  public function sendSecondaryEmails($reason,$secondaryEmails,$notificationRequest )
    {
      
    }

}
