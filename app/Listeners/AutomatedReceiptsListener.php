<?php

namespace App\Listeners;


use App\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Receipt;
class AutomatedReceiptsListener
{
 
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $dateToRun=Carbon::now('UTC')->toDateTimeString();
        $receiptsToRun = 
        Booking::doesntHave('receipts')
        ->where('end','<=',$dateToRun)
        ->get();
    //also 

        
    foreach ($receiptsToRun as $bookings) {
             $booking_id = $bookings->id;
            $requested_by = 'System';
            $amount=$bookings->topActiveBookingPricing()->amount;
         if($amount>0){
          Receipt::create([
                "booking_id" => $booking_id,
                "request_date" => $dateToRun,
                "requested_by" => $requested_by,
                "requested_by_id" => 0,
                "duplicated" => false
            ]);
         }
  

            //$responseCreateReceipt =  $this->create_receipt_trait($createReceiptRequest);
                
               
                    
               
            }
    }
}
