<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use App\Receipt;

class Receipt extends Notification
{
    

   protected $receipt;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Receipt $receipt)
    {
        $this->receipt=$receipt;
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
        return ['mail'];
    }

 public function toMail($notifiable)
    {


        
     return (new MailMessage)
        ->identifier(config('postmark.templates.receipt_template'))
        ->include([
            
            'support_url'=>config('postmark.static_variables.support_url'),

        ]);
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
