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
class ManagerStatusChangeBookingNotification extends Notification
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
        return $notifiable->managernotifications()->first()->bookingNotifications();
    }



 public function toMail($notifiable)
    {
       
      
        $bookingPricing=$this->booking->topActiveBookingPricing();
        $name=$this->getClientFullName($this->booking);
        $status=$this->booking->booking_status=='C'?'Cancelled':'Rescheduled';
        $therapistFirstName=$this->getTherapistFirstName($this->booking);
     return (new MailMessage)
        ->identifier(config('postmark.templates.manager_booking_status_change_template'))
        ->include([
            'subject'=>"{$therapistFirstName}, your booking has been {$status}",
            'date_text'=>$this->booking->getMassageDate(),
            'client_name'=>$name,
            'therapist_name'=>$therapistFirstName,
            'support_url'=>config('postmark.static_variables.support_url'),
            'status'=>$status, 
            "therapist_amount"=>null
        ]);
    }




 public function toTwilio($notifiable)
    {

        $status=$this->booking->booking_status=='C'?'Cancelled':'Rescheduled';
         return (new TwilioSmsMessage())
            ->content("{$this->getTherapistFirstName($this->booking)}, a booking has been {$status} with {$this->getClientFullName($this->booking)}  - on {$this->booking->getMassageDate()} - Thank you Thrivr Team ");
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
