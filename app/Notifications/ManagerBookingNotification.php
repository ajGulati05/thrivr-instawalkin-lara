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
use App\Http\Traits\v2\PersonalizeTrait;
use App\Http\Traits\v2\PriceCalculationTraitV2;
class ManagerBookingNotification extends Notification
{

use PersonalizeTrait, PriceCalculationTraitV2;
 protected $booking;
 protected $manager;
 protected $bookable;
 protected $project;
 protected $bookingAmounts;

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
        $this->bookingAmounts=$this->SpitOutCorrectAmounts($this->booking->topActiveBookingPricing());
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
       
        

        $name=$this->getClientFullName($this->booking);
       
      
      
       
      
       

  
        
     return (new MailMessage)
        ->identifier(config('postmark.templates.manager_booking_template'))
        ->include([
             'name'=>$this->getTherapistFirstName($this->booking),
            'support_url'=>config('postmark.static_variables.support_url'),
            "length" =>$this->project->length,
            "client_name"=>$name,
            "date_text"=>$this->booking->getMassageDate(),
            "paid_by"=>$this->booking->getPaidBy(),
            "amount"=> $this->bookingAmounts['amount'],
            "tax_amount"=> $this->bookingAmounts['tax_amount'],
            "discount_amount"=> $this->bookingAmounts['discount_amount'],
             "total_amount"=> $this->bookingAmounts['total_amount'],
        ]);
    }


 public function toTwilio($notifiable)
    {
       return (new TwilioSmsMessage())
            ->content("{$this->getTherapistFirstName($this->booking)}, you have a new {$this->project->length} appointment with {$this->getClientFullName($this->booking)} - on {$this->booking->getMassageDate()}. Payment Type {$this->booking->getPaidBy()}.
            Price Breakdown

            Price - {$this->bookingAmounts['amount']}
            Tax - {$this->bookingAmounts['tax_amount']}
            Discount Amount - {$this->bookingAmounts['discount_amount']}
            
            Total - {$this->bookingAmounts['total_amount']}
            
             - Thank you Thrivr Team ");
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
