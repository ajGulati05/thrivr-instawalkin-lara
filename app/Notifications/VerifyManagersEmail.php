<?php

namespace App\Notifications;


use Illuminate\Auth\Notifications\VerifyEmail;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;

use Illuminate\Support\Facades\Log;
class VerifyManagersEmail extends VerifyEmail
{
   

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $verificationUrl = $this->verificationUrl($notifiable);
          if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }


          return (new MailMessage)
        ->identifier(config('postmark.templates.verification_template'))
        ->include([
            'name' => $notifiable->first_name,
            'action_url'=> $verificationUrl

        ]);
     
    }

}
