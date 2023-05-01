<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class CreditCardErrorToUserNotification extends Notification
{
    use Queueable;
    protected $exceptionRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $request)
    {
        $this->exceptionRequest = $request;
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
        $fromEmail = config('mail.fromTeam');
        Log::debug('EXCEPTION CREDIT CARD REQUEST NOTIFICAITON ');
        Log::debug(json_encode($this->exceptionRequest[0]));
        $request = $this->exceptionRequest[0];
        $user_id = $request['user_id'];
        $card_id = $request['card_id'];
        $error = $request['error'];
        // $reason=$request['reason'];

        $customer = User::find($user_id);
        $customerProfile = $customer->userprofiles;
        $customerInfo['firstname'] = $customerProfile->firstname;
        $customerInfo['email'] = $customer->email;

        Log::debug('CUSTOMER INFO');
        Log::debug($customerInfo);

        return (new MailMessage)
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject('Credit Card Failure')
            ->greeting('Exception Message!')
            ->line("Sorry but there is an issue. Instawalkin is looking at this issue and the team will be in contact with your shortly")
           ->line('USER DETAILS:')
            ->line("id: " . $user_id)
            ->line("email: " . $customerInfo['email'])
            ->line("card ID: " . $card_id)
            ->line("ERROR: ")
            ->line($error);
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
