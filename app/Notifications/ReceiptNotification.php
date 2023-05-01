<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use App\Receipt;
use Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\v2\PersonalizeTrait;
use App\Helpers\ReceiptPDFClass;


class ReceiptNotification extends Notification
{
    use PersonalizeTrait;

   protected $receipt;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Receipt $receipt)
    {
        $this->receipt=$receipt;
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
        return ['mail'];
    }

    public function shouldInterrupt($notifiable) {

        $booking=$this->receipt->bookings;

        Log::debug('shouldInterrupt? booking: ' . $booking->id);
        // We do not interrupt for non-empty booking status anymore (logic removed)
        // We interrupt if no monetary value
        $activeprice = $booking->topActiveBookingPricing();
        if ( empty($activeprice->amount) && empty($activeprice->amount_1) )
        {
            Log::debug('Cancelled due to empty amount and amount 1 values');
            return true;
        }
    }

 public function toMail($notifiable)
    {
        

//$mpdf->Output();
        $booking=$this->receipt->bookings;
 
        $manager=$booking->manager;
        $bookingPricing=$booking->topActiveBookingPricing();
        $bookable=$booking->bookable;

        $guest=$bookable=="App\User"?false:true;
        $booking_url=null;
        if(!$guest){
           $booking_url=config('constants.urls.webapp').'/order-detail/'.$booking->timekit_booking_id;
        }
        $name=$this->getClientFirstName($booking);
      $totalPrice=$bookingPricing->amount+$bookingPricing->tax_amount -$bookingPricing->discount_amount;
     $fullName=$this->getClientFullName($booking);



            $pdfReceipt= new ReceiptPDFClass($booking,$manager,$bookingPricing,$this->receipt,$fullName);
              $content=$pdfReceipt->createReceipt();
     return (new MailMessage)
        ->identifier(config('postmark.templates.receipt_template'))
        ->include([
           'name'=>$name,
           'clientFullName'=>$fullName,
            'support_url'=>config('postmark.static_variables.support_url'),
            'total_text'=>$totalPrice,
            'therapist_name'=>$manager->fullName,
            'business_name'=>$manager->business_name,
            'address'=>$manager->profiles->address,
            'business_name'=>$manager->business_name,
            'city'=>$manager->profiles->city,
            'province'=>$manager->profiles->province,
            'postal_code'=>$manager->profiles->postal_code,
            'license'=>$manager->manager_licenses()->latest()->first()->license_number,
            'price'=>$bookingPricing->amount,
            'tip'=>$bookingPricing->tip_amount,
            'discount'=>$bookingPricing->discount_amount?$bookingPricing->discount_amount:null,
            'tax'=>$bookingPricing->tax_amount ,
            'booking_url'=>$booking_url,
            'date_text'=>$booking->getMassageDateWithYear(),
            'duplicate'=>$this->receipt->duplicated?true:false,
            'duration'=>$booking->project->description,
            'massage_id'=>$booking->id,
            'therapist_phone_number'=>$manager->profiles->phone,
            "paid_by_code"=>$booking->paid_by,
            "paid_by_2_code"=>$booking->paid_by_2,
            "total_amount"=>$booking->getBookingTotal()+$bookingPricing->tip_amount,
            "paid_by"=>optional($booking->paymentTypes)->description?:'Credit Card',
            "paid_by_2"=>optional($booking->paymentTypesTwo)->description,
            "amount_1"=>$bookingPricing->amount_1,
             "amount_2"=>$bookingPricing->amount_2
        ])
      ->attachData($content, 'receipt.pdf', [
                    'mime' => 'application/pdf',
                ]);
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
