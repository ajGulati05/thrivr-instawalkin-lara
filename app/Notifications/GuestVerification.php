<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

use Illuminate\Notifications\Notifiable;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;

class GuestVerification extends Notification
{

  /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;
    protected $name;
    protected $therapist;

    public function __construct( $name,$therapist) {
        $this->name=$name;
        $this->therapist=$therapist;
}
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {

        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }
        
     return (new MailMessage)
        ->identifier(config('postmark.templates.guest_verification_email'))
        ->include([
            'name' => $this->name,
            'verificationUrl' => $verificationUrl,
            'therapist_name'=>$this->therapist->fullName,
            'therapist_business_name'=>$this->therapist->business_name,
            'therapist_first_name'=>$this->therapist->first_name,
            'button_message'=>'Create Account',
            'message'=>' If this is your massage therapist, you can create an account by clicking'

        ]);
    }





        /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {


        $url= URL::temporarySignedRoute(
            'verification.verify.guest',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 160)),
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
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}