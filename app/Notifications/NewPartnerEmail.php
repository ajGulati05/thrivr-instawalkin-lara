<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Manager;
//
class NewPartnerEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $manager;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manager $manager)
    {
        //

        $this->manager=$manager;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
         
        $fromEmail=config('mail.fromTeam');
        return (new MailMessage)
                    ->from($fromEmail['address'],$fromEmail['name'])
                    ->subject('Congrats on becoming an instawalkin Partner')
                    ->greeting('Hello ' . $this->manager->locations->name)
                    ->line('Welcome to instawalkin.')
                    ->line('Your Username is : ' . $this->manager->email)
                    ->line('We will be sending you another email shortly to reset your email.')
                    ->line("If you dont get the email, in the next few minutes please call us at +1-306-2625152.")
                    ->line('Thank you for being our partner!')
                    ->salutation('The instawalkin team');
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
