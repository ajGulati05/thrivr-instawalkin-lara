<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;

use App\UserRecommendedRmt;
use Illuminate\Notifications\Messages\SlackMessage;
use Carbon\Carbon;
class RecommendedRmtNotification extends Notification
{

protected $userRecommendedRmt;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserRecommendedRmt $userRecommendedRmt)
    {
            $this->userRecommendedRmt=$userRecommendedRmt;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
public function toSlack($notifiable)
    {


      
     return (new SlackMessage)
                ->content("NEW RECOMMENDATION : {$this->userRecommendedRmt->therapist_business} has been recommended {$this->userRecommendedRmt->therapist_email} {$this->userRecommendedRmt->therapist_name}");
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
