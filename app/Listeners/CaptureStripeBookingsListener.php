<?php

namespace App\Listeners;

use App\Booking;
use App\BookingPricing;
use App\BookingTransaction;
use App\Events\CaptureStripeBookings;
use App\Http\Traits\v2\StripeTraitV2;
use App\Project;
use App\Stripedata;
use Cartalyst\Stripe\Exception\MissingParameterException;
use Cartalyst\Stripe\Exception\NotFoundException;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CaptureStripeBookingsListener
{

   use StripeTraitV2;


    /**
     * Handle the event.
     *
     * @param  CaptureStripeBookings  $event
     * @return void
     */
    public function handle(CaptureStripeBookings $event)
    {

        $dateToAuthorize=Carbon::now()->toDateString();

        $bookingsToUpdate = Booking::where('paid_by', '=', 'CR')
        ->whereDate('date_to_authorize',$dateToAuthorize)->
        where('closed',false)->get();

     

        if (count($bookingsToUpdate) > 0) {


            foreach ($bookingsToUpdate as $booking) {
                $booking_pricing = BookingPricing::where('booking_id', $booking->id)->where('active', true)->first();
                 

                      if ($booking_pricing != null) {
                    //WE QUERY THE STRIPE_ID FROM BOOKING TRANSACTIONS, THE FIRST FROM THE LIST
                    $bookingTx = BookingTransaction::where('booking_pricing_id', $booking_pricing->id)
                        ->where('active', true)->first();
               
                  
                                try {
          
                                        
                                            // WE CREATE A NEW CHARGE WITH TIP 
                                            $charge = $this->_capture($bookingTx->charge_id);
                                 
                                   
                                            $booking->closed = true;
                                            $booking->save();

                                            //ADD INFO IN BOOKING TRANSACTION 

                                            $bookingTx->stripe_code_status_authorize = $charge['status'];
                                            $bookingTx->stripe_reason_authorize =$charge['status'];
                                            $bookingTx->save();
                   
                                } catch (Exception $e) {

                                   Log::crtical('CaptureStripeBookingsListener'. $booking->id);
                                    
                                }
                       
                    
                }
            }
        }
    }
}
