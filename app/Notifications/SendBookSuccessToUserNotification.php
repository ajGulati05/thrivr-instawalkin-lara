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

class SendBookSuccessToUserNotification extends Notification
{
    use Queueable;
    protected $notificationRequest;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $notificationRequest)
    {
        $this->notificationRequest = $notificationRequest;
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
        Log::debug('BOOK SUCCESS REQUEST NOTIFICAITON -----------------------------');
        Log::debug(json_encode($this->notificationRequest[0]));
        $request = $this->notificationRequest[0];
        $booking_id = $request['booking_id'];
        $user_id = $request['user_id'];
        $bookable_type = $request['bookable_type'];
        $default_uuid = $request['default_uuid'];

        $getBookingInfoResource = new GetBookingInfoForNotficationsResource($booking_id, $user_id);
        $responseGetBookingInfoResource = json_decode(json_encode($getBookingInfoResource), true);
  
      Log::debug('RESPONSE RESOURCE GETITNG BOOKING ');
        Log::debug($responseGetBookingInfoResource['customer_firstname']);

        // $url = url(
        //     '/testing_unsubscribe',
        //     [
        //         'bookable_type' => $bookable_type,
        //         "default_uuid" => $default_uuid
        //     ]
        // );
        $url = url(
            '/testing_unsubscribe'
        );
        Log::debug($url);
         $mailMessage = new MailMessage();
        $mailMessage
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject('Booking Success! From ' . $fromEmail['address'])
            ->greeting('Hello! ' . $responseGetBookingInfoResource['customer_firstname'])
            ->line('You have a new appointment booked through instawalkin with ' . $responseGetBookingInfoResource['therapist_firstname'] . ' at ' . $responseGetBookingInfoResource['massage_time']  . '.')
            ->line('The address is '.$responseGetBookingInfoResource['address_description'].', ' . $responseGetBookingInfoResource['address'] . ', ' . $responseGetBookingInfoResource['city'])
            ->line('CHARGES: ')
            ->line('Payment Method: '.$responseGetBookingInfoResource['payment_method'])
            ->line('Price: ' . $responseGetBookingInfoResource['project_pricing_amount'])
            ->line('Tax: ' . $responseGetBookingInfoResource['taxAmount'] . ' CAD');
  if(isset($responseGetBookingInfoResource['discountAmount']) && $responseGetBookingInfoResource['discountAmount']>0)
            {

                $discountedTotalAmount=$responseGetBookingInfoResource['amountToPay']-$responseGetBookingInfoResource['discountAmount'];
                $mailMessage
                 ->line('Discount Amount: ' . $responseGetBookingInfoResource['discountAmount'] . ' CAD')
                  ->line('Total: ' . $discountedTotalAmount. ' CAD');
              }
            else{
            $mailMessage
            ->line('Total: ' . $responseGetBookingInfoResource['amountToPay'] . ' CAD');
        }
            $mailMessage
            ->line('Thank you for using instawalkin.')
            ->line('We value your business!')
            ->line('Sincerely,')
            ->line('The instawalkin team');
return $mailMessage;
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
