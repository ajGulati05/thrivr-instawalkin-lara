<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

use Illuminate\Notifications\Notifiable;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;

class CustomUserVerificationEmail extends Notification
{

  /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;
    protected $name;

    public function __construct( $name) {
        $this->name=$name;
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
        ->identifier(config('postmark.templates.user_verification_template'))
        ->include([
            'name' => $this->name,
            'verificationUrl' => $verificationUrl

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
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
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