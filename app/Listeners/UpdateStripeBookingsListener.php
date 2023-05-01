<?php

namespace App\Listeners;

use App\Booking;
use App\BookingPricing;
use App\BookingTransaction;
use App\Events\UpdateStripeBookings;

use App\Http\Traits\v2\StripeTraitV2;
use App\Project;
use App\ProjectPricing;
use App\Stripedata;
use App\User;

use Cartalyst\Stripe\Stripe;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateStripeBookingsListener
{

   use StripeTraitV2;

    /**
     * Handle the event.
     *
     * @param  UpdateStripeBookings  $event
     * @return void
     */
    public function handle(UpdateStripeBookings $event)
    {
         $todaysTime = Carbon::now()->toDateTimeString();
         $prevTime=Carbon::now()->addHours(-24)->toDateTimeString();
        $todaysFourDayTime = Carbon::now()->addDays(-4)->toDateTimeString();
        $prevFourDayTime=Carbon::now()->addDays(-5)->toDateTimeString();
        //paid by credit card
        $bookingsToUpdate = Booking::where('paid_by', '=',  Booking::PAID_BY_CREDIT_CARD)
        ->where('closed',false)
        ->whereNull('date_to_authorize')
        ->whereBetween('start',[$prevTime,$todaysTime])->get();


        $bookingsToClose = Booking::where('paid_by', '!=',  Booking::PAID_BY_CREDIT_CARD)
            ->where('closed',false)
            ->whereNull('date_to_authorize')
            ->whereBetween('start',[$prevFourDayTime,$todaysFourDayTime])->get();

        foreach ($bookingsToClose as $closeBooking)
        {
            $closeBooking->closed = true;
            $closeBooking->save();
        }

          foreach ($bookingsToUpdate as $booking) {

                
                 $massageStartTime = Carbon::create($booking->start); //assuming this is in UTC in the database

                        $this->_postCreditCharges($booking);
                               //here we calculate the date_to_authorize
                        $dateToCharge = $massageStartTime;
                        $dateToCharge->addDays(4);
                        $booking->date_to_authorize = $dateToCharge;
                        $booking->save();
               
            }
        
    }
}
