<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use App\Receipt;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

use Illuminate\Support\Str;

use App\Guest;
use Illuminate\Support\Facades\URL;
class BookAMassageReminderNotification extends Notification
{



   /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


  /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {   

        if($notifiable instanceof Guest){
                return $notifiable->emailFutureReminder();
        }
    return $notifiable->usernotifications()->first()->emailFutureReminder();
    }



 public function toMail($notifiable)
    {

      
     return (new MailMessage)
        ->identifier(config('postmark.templates.monthly_reminder'))
        ->include([
        "name"=>$notifiable->firstNameValue,
        "unsubscribe_link"=>$this->unsubscribeUrl($notifiable),
        "support_url"=>config('postmark.static_variables.support_url'),
        ]);
    }





    

      /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function unsubscribeUrl($notifiable)
    {
        $routeUrl='unsubscribe.future.user';
        if($notifiable instanceof App\Guest){
            $routeUrl='unsubscribe.future.guest';
        }

        $url= URL::signedRoute(
             $routeUrl,
            [
                'instauuid' => $notifiable->instauuid
            ]
        );
          return $url;
    }
   
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
