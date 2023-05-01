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
use App\Http\Traits\v2\FormFlowTrait;
use App\Http\Traits\v2\PersonalizeTrait;
class UserStatusChangeBookingNotification extends Notification
{
use PersonalizeTrait;
use FormFlowTrait;
 protected $booking;
 protected $manager;
 protected $bookable;
 protected $project;

   /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking=$booking;
        $this->manager=$booking->manager;
        $this->bookable=$booking->bookable;
        $this->project=$booking->project;
        //
    }


  /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->booking->isGuest()?['mail']:$notifiable->usernotifications()->first()->emailConfirmations();
    }



 public function toMail($notifiable)
    {
       
      
      //  $bookingPricing=$this->booking->topActiveBookingPricing();
     
        $name=$this->getClientFirstName($this->booking);
        $status=$this->booking->booking_status=='C'?'Cancelled':'Rescheduled';
     return (new MailMessage)
        ->identifier(config('postmark.templates.user_booking_status_change_template'))
        ->include([
            'subject'=>"{$name}, your booking has been {$status}",
            'date_text'=>$this->booking->getMassageDate(),
            'name'=>$name,
            'therapist_name'=>$this->manager->fullName,
            'support_url'=>config('postmark.static_variables.support_url'),
            'status'=>$status, 
            "amount"=>null
        ]);
    }



 public function toTwilio($notifiable)
    {
  return null;
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
