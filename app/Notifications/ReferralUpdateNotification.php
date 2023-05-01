<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
class ReferralUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        return $notifiable->usernotifications()->first()->emailProductUpdate();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $referralTemplateToUse=config('postmark.templates.referral_update');

        // TODO can be removed anytime now
        $releaseDate = Carbon::parse('2020-11-01');
        if($notifiable->created_at->lt($releaseDate))
        {
            $referralTemplateToUse=config('postmark.templates.old_referral_update');
        }
        //can be removed till here



        $url=config('constants.urls.webapp').'/signup?referral='.$notifiable->affiliate_id;
        $body=urlencode("Your friend  {$notifiable->firstNameValue} , thought you could use a little rest and relaxation so they sent you $10 off toward a relaxing massage with Thrivr Massage!  {$url}");
        $urlEncondedName = urlencode($notifiable->firstNameValue);
        $urlEncondedReferralCode = urlencode($notifiable->affiliate_id);
        return (new MailMessage)
            ->identifier($referralTemplateToUse)
            ->include([
                    "name"=>$notifiable->firstNameValue,
                    "refer_a_friend_link_text"=>route('social.sendtext',['name'=>$urlEncondedName,'refcode'=>$urlEncondedReferralCode]),
                    "refer_a_friend_link_email"=>"mailto:?body={$body}",
                    "refer_a_friend"=>config('constants.urls.webapp').'/login?redirectFrom=/promo-code',
                    "referral_code"=>$notifiable->affiliate_id,
                    "unsubscribe_link"=>$this->unsubscribeUrl($notifiable),

            ]);
    }


    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function unsubscribeUrl($notifiable)
    {
        $routeUrl='unsubscribe.update.user';


        $url= URL::signedRoute(
            $routeUrl,
            [
                'instauuid' => $notifiable->instauuid
            ]
        );
        return $url;
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
