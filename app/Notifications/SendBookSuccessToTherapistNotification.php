<?php

namespace App\Notifications;

use App\Booking;
use App\Guest;
use App\Manager;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\TwilioTrait;
use App\ManagerNotifications;
class SendBookSuccessToTherapistNotification extends Notification
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
        Log::debug('SEND BOOK SUCCESS TO THERAPIST NOTIFICATION');
        Log::debug(json_encode($this->notificationRequest[0]));
        $request = $this->notificationRequest[0];
        $responseGetBookingInfoResource = $request['responseGetBookingInfoResource'];
   

        Log::debug('RESPONSE RESOURCE GETITNG BOOKING ');
        Log::debug($responseGetBookingInfoResource['customer_firstname']);
        $mailMessage = new MailMessage();
        $mailMessage
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject($responseGetBookingInfoResource['therapist_firstname'] . ' You have a new Massage Appointment at '.$responseGetBookingInfoResource['massage_time'])
            ->greeting('Hello! ' . $responseGetBookingInfoResource['therapist_firstname'])
            ->line('You have a new appointment booked through instawalkin with ' . $responseGetBookingInfoResource['customer_firstname']. ' at ' . $responseGetBookingInfoResource['massage_time']. '.')
            ->line('CLIENT PREFERENCES:')
            ->line('Massage: ' . $responseGetBookingInfoResource['project_name'])
            ->line('Manager Speciality: ' . $responseGetBookingInfoResource['manager_speciality_code'])
            ->line('CLIENT CHARGES:')
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
         



            return  $mailMessage;
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
