<?php

namespace App\Notifications;

use App\Booking;
use App\Guest;
use App\Http\Resources\GetBookingInfoForNotficationsResource;
use App\Manager;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CancelBookingToUserNotification extends Notification
{
    use Queueable;
    protected $cancelRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $cancelRequest)
    {
        $this->cancelRequest = $cancelRequest;
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
        Log::debug('CANCEL REQUEST NOTIFICAITON FOR USER ');
        Log::debug(json_encode($this->cancelRequest[0]));
        $request = $this->cancelRequest[0];
        $booking_id = $request['booking_id'];
        $user_id = $request['user_id'];

        $getBookingInfoResource = new GetBookingInfoForNotficationsResource($booking_id,$user_id);
        $responseGetBookingInfoResource = json_decode(json_encode($getBookingInfoResource),true);
        Log::debug('RESPONSE RESOURCE GETITNG BOOKING ');
        Log::debug($responseGetBookingInfoResource['customer_firstname']);

        if($responseGetBookingInfoResource['cancellationFee']!='0.00'){
            return (new MailMessage)
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject('Cancellation Notification! for ' . $responseGetBookingInfoResource['customer_firstname'])
            ->greeting('Hello! ' . $responseGetBookingInfoResource['customer_firstname'])
            ->line('Your scheduled booking through instawalkin with ' . $responseGetBookingInfoResource['therapist_firstname'] . ' at ' . $responseGetBookingInfoResource['massage_time'] . ' has been cancelled. A cancellation fee of ' . $responseGetBookingInfoResource['cancellationFee']. ' CAD has been charged and will be credited to your account.')
            ->line('Thank you for using instawalkin.')
            ->line('We value your business!')
            ->line('Sincerely,')
            ->line('The instawalkin team');
        }else{
            return (new MailMessage)
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject('Cancellation Notification! for ' . $responseGetBookingInfoResource['customer_firstname'])
            ->greeting('Hello! ' . $responseGetBookingInfoResource['customer_firstname'])
            ->line('Your scheduled booking through instawalkin with ' . $responseGetBookingInfoResource['therapist_firstname'] . ' at ' . $responseGetBookingInfoResource['massage_time'] . ' has been cancelled.')
            ->line('Thank you for using instawalkin.')
            ->line('We value your business!')
            ->line('Sincerely,')
            ->line('The instawalkin team');
        }

   
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
