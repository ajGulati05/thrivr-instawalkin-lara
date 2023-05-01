<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;

class UserReferralInviteNotification extends Notification
{
   
    protected $rewardee_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rewardee_name)
    {
        $this->rewardee_name=$rewardee_name;
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
        ->identifier(config('postmark.templates.referral_email'))
        ->include([
            "rewardee_name"=>$this->rewardee_name,
            "name"=>$notifiable->name,
            "action_url"=>config('constants.urls.webapp').'/signup?referral='.$notifiable->user->affiliate_id,
          
          
    
         

            
        ]);
    }

public function shouldInterrupt($notifiable) {

     if($notifiable->accepted){

    
            return true;
    };

   
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
