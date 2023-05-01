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
class IntakeFormReminderNotification extends Notification
{

use FormFlowTrait;
use PersonalizeTrait,GuestTrait;
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
        $this->doesEmailExistsInUsers($this->booking->bookable)?false:true;
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
       return ['mail'];
    }



 public function toMail($notifiable)
    {


     return (new MailMessage)
        ->identifier(config('postmark.templates.intake_reminder'))
        ->include([
            'subject'=>"{$this->name}, please fill out your intake and covid form before your appointment.",
            'date_text'=>$this->booking->getMassageDate(),
            'name'=>$this->name,
            'therapist_name'=>$this->manager->fullName,
            'support_url'=>config('postmark.static_variables.support_url'),
            "address_description"=> isset($this->manager->profiles->address_description)?$this->manager->profiles->address_description:null,
            "parking_description"=> isset($this->manager->profiles->parking_description)?$this->manager->profiles->parking_description:null,
                 //things to add 
            "action_message"=>"If you haven't already please fill your Intake and Covid form before your appointment.",
            "action_url"=>$this->createEmailFormFlowURL($this->booking),
            "action_button"=>"Fill Forms"
          
    
         

            
        ]);
    }

public function shouldInterrupt($notifiable) {

     if($this->booking->closed || !is_null($this->booking->booking_status)){

    
            return true;
    };

    if(!is_null($this->booking->latestCovidForm))
    {

        return true;

    }

return false;

  
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
