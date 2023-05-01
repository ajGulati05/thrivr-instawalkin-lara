<?php

namespace App\Notifications;

use App\Http\Resources\GetBookingInfoForNotficationsResource;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendReceipts extends Notification implements ShouldQueue
{
    use Queueable;
    protected $receiptRequest;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $receiptRequest)
    {
        $this->receiptRequest = $receiptRequest;
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
        Log::debug('SEND RECEIPT REQUEST NOTIFICAITON ');
        Log::debug(json_encode($this->receiptRequest[0]));
        $request = $this->receiptRequest[0];
        $booking_id = $request['booking_id'];
        $user_id = $request['user_id'];
        $duplicate=$request['duplicate'];
            
        $getBookingInfoResource = new GetBookingInfoForNotficationsResource($booking_id, $user_id);
        $responseGetBookingInfoResource = json_decode(json_encode($getBookingInfoResource), true);
        Log::debug('RESPONSE RESOURCE GETITNG BOOKING ');
        Log::debug($responseGetBookingInfoResource['customer_firstname']);
        $mailMessage = new MailMessage();
      $mailMessage
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject('Receipt From ' . $responseGetBookingInfoResource['therapist_firstname'] . ' ' . $responseGetBookingInfoResource['therapist_lastname'])
            ->greeting('Hello ' . $responseGetBookingInfoResource['customer_firstname'] . ' ' . $responseGetBookingInfoResource['customer_lastname'])
            ->line('This is your receipt from ' . $responseGetBookingInfoResource['therapist_firstname'] . ' ' . $responseGetBookingInfoResource['therapist_lastname'])
            ->line('Address: ' . $responseGetBookingInfoResource['address'])
            ->line('Address Description: '.$responseGetBookingInfoResource['address_description'])
            ->line('Postal Code: ' . $responseGetBookingInfoResource['therapist_postal_code'])
            ->line('Phone Number: ' . $responseGetBookingInfoResource['therapist_phone'])
            ->line('License Number: ' . $responseGetBookingInfoResource['therapist_license_number']);
    if($duplicate>0)
            {
                  Log::debug('RESPONSE RESOURCE GETITNG BOOKING '.$duplicate);
             $mailMessage    
            ->line('For Order# ' .$request['booking_id'].' - Duplicate Receipt');
        }else{
              Log::debug('RasasESPONSE RESOURCE GETITNG BOOKING '.$duplicate);
             $mailMessage    
            ->line('For Order# ' .$request['booking_id']);
        }
            $mailMessage
            ->line('Payment Method: '.$responseGetBookingInfoResource['payment_method'])
            ->line('Price: ' . $responseGetBookingInfoResource['project_pricing_amount'])
            ->line('Tax: ' . $responseGetBookingInfoResource['taxAmount'] . ' CAD');
           if(isset($responseGetBookingInfoResource['tipAmount']) && $responseGetBookingInfoResource['tipAmount']>0)
            {
                 $mailMessage
                 ->line('Tip Amount: ' . $responseGetBookingInfoResource['tipAmount'] . ' CAD');

            }
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
            ->line('Practitioner# ' . $responseGetBookingInfoResource['therapist_license_number'])
            ->line('Date: ' . $responseGetBookingInfoResource['massage_time'] ) //should be in human readable form
            ->line('GST Included ')
            ->line('Thank you for using the instawalkin app!');

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
