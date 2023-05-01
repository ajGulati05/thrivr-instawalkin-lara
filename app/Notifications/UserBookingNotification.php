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
use Illuminate\Support\Str;

use App\Http\Traits\v2\GuestTrait;
use Illuminate\Support\Facades\URL;
use Spatie\CalendarLinks\Link;

class UserBookingNotification extends Notification
{

use FormFlowTrait;
use PersonalizeTrait,GuestTrait;
 public static $toMailCallback;
 protected $booking;
 protected $manager;
 protected $bookable;
 protected $project;
 protected $reminder;
protected $name;
protected $signUpLink;

   /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking,$reminder=false)
    {
        $this->booking=$booking;
        $this->manager=$booking->manager;
        $this->bookable=$booking->bookable;
        $this->project=$booking->project;
        $this->reminder=$reminder;
        $this->name=  $this->getClientFirstName($this->booking);
        $this->signUpLink=false;
        if($this->booking->isGuest()){
       $this->signUpLink= $this->doesEmailExistsInUsers($this->booking->bookable)?false:true;
    }


    }


  /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($this->reminder)
        {
            //SET THIS for text/email reminder
         if( $this->booking->isGuest())
            {
               return $notifiable->email_reminder?['mail']:null;
        }
else{
 return   $notifiable->usernotifications()->first()->emailReminderNotifications();

}

    return null;
        }

        else{
             return $this->booking->isGuest()?['mail']:$notifiable->usernotifications()->first()->emailConfirmations();
        }
    }



 public function toMail($notifiable)
    {

        $verificationUrl=null;
        if( $this->booking->isGuest()){
         $verificationUrl = $this->signUpLink? $this->guestVerificationUrl($notifiable):$this->guestAcceptanceUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }
       }

        //$bookingPricing=$this->booking->topActiveBookingPricing();
      //  $totalPrice=$bookingPricing->amount+$bookingPricing->tax_amount -$bookingPricing->discount_amount;

        $subject =  $this->reminder?"{$this->name}, reminder for your upcoming massage at {$this->manager->business_name}":"{$this->name}, here are your booking details";

        // action url points to users booking
        $action_message="View your booking";
        $action_url=config('constants.urls.webapp').'/bookings/'.$this->booking->timekit_booking_id;
        $action_button="Your Booking";

        if($this->booking->isGuest() && !$this->reminder){
            $action_message="You can view your bookings by logging on here";
            $action_url=$verificationUrl;
             $action_button="Sign Up";
        }

        if($this->reminder){
             $action_message="If you haven't already please fill your Intake and Covid form before your appointment.";
            $action_url=$this->createEmailFormFlowURL($this->booking);
                $action_button="Fill Forms";
        }

        $calender_link=base64_decode(explode (",",$this->createCalendarLink())[1]);
        $directions = $this->getGoogleLink();
     return (new MailMessage)
        ->identifier(config('postmark.templates.user_booking_template'))
        ->include([
            'subject'=>$subject,
            'date_text'=>$this->booking->getMassageDate(),
            'name'=>$this->name,
            'therapist_name'=>$this->manager->fullName,
            'support_url'=>config('postmark.static_variables.support_url'),
            "address"=>$this->buildAddress(),
            "address_description"=> isset($this->manager->profiles->address_description)?$this->manager->profiles->address_description:null,
            "parking_description"=> isset($this->manager->profiles->parking_description)?$this->manager->profiles->parking_description:null,
                 //things to add
            "action_url"=>$action_url,
            "action_message"=>$action_message,
           "action_button"=>$action_button,
            "directions"=> $directions,

            "unsubscribe_link"=>$this->reminder?$this->unsubscribeUrl($notifiable):null,

        ])->attachData($calender_link, 'appointment.ics');
    }

public function createCalendarLink(){
    $from = $this->booking->getMassageStartDate();
    $to  = $this->booking->getMassageEndDate();
    $link = Link::create('Massage appointment', $from, $to)->address($this->buildAddress())->ics();

    return $link;
}

public function buildAddress(){
   return $this->manager->business_name.' '.$this->manager->profiles->address.' '.$this->manager->profiles->city.' '. $this->manager->profiles->postal_code ;

}
public function getGoogleLink(){
    $encodedAddress="https://www.google.com/maps/dir/?api=1&destination=".urlencode($this->buildAddress());

    return $encodedAddress;
}
public function shouldInterrupt($notifiable) {

     if($this->booking->closed || !is_null($this->booking->booking_status)){


            return true;
    };


}


 public function toTwilio($notifiable)
    {
        if($this->reminder==1 )
        {

           return (new TwilioSmsMessage())
            ->content("Just a reminder, you have an appointment on {$this->booking->getMassageDate()} at {$this->manager->business_name} with {$this->manager->fullName}. Text STOP to unsubscribe.");
        }

            return null;
    }

      /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function unsubscribeUrl($notifiable)
    {
        $routeUrl='unsubscribe.user';
        if($this->booking->isGuest()){
            $routeUrl='unsubscribe.guest';
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
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function guestVerificationUrl($notifiable)
    {


        $url= URL::temporarySignedRoute(
            'verification.verify.guest',
            Carbon::now()->addMinutes(config('auth.verification.expire', 160)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
                'verify'=>true,
                'firstname'=>$notifiable->firstname,
                'phone'=>isset($notifiable->phone)?'N':'Y',
            ],
            false
        );
          return config('constants.urls.webapp').$url;
    }


    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function guestAcceptanceUrl($notifiable)
    {


        $url= URL::temporarySignedRoute(
            'verification.verify.guest.acceptance',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
                'firstname'=>$notifiable->firstname

            ],
            false
        );
        return config('constants.urls.webapp').$url;
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
