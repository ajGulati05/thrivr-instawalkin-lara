<?php

namespace App\Http\Traits;

use App\Booking;
use App\BookingPricing;
use App\BookingStatusCode;
use App\BookingTransaction;
use App\Http\Requests\CancelBookingTimekitRequest;

use App\Manager;
use App\ManagerSpeciality;
use App\Notifications\SendReceipts;
use App\Project;
use App\ProjectPricing;
use App\Receipt;
use App\Stripedata;
use App\User;
use Cartalyst\Stripe\Exception\NotFoundException;
use Cartalyst\Stripe\Exception\StripeException;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Exception;
use Notification;

trait BookingTrait
{
    use StripeTrait;
    //use NotificationsTrait;

    public function saveBookingTrait(Request $request)
    {
      
  Log::debug('SAVE BOOKING IN DATABASE REQUEST');
        Log::debug($request);

        $bookable_type = $request->bookable_type; //this is for the user  type user or guest
        $bookable_id = $request->bookable_id; //this is for the user or guest id
        $manager_id = $request->manager_id;
        $project_id = $request->project_id;
        $start = Carbon::create($request->start, 'UTC');
        $start->setTimezone('UTC');
        $end = Carbon::create($request->end, 'UTC');
        $end->setTimezone('UTC');
        $timekit_booking_id = $request->timekit_booking_id;
        $when = Carbon::now(); //this is the time when the booking was made
        $date_to_authorize = null; //is set to null becasue the cron job is going to calculate this
        $app_source = $request->app_source;
        $by_source = $request->by_source;
        $paid_by = $request->paid_by;
        $project_pricing_id = $request->project_pricing_id;
        $manager_speciality_id = null;
        if ($by_source == config('constants.configurations.by_source_therapist')) {
            Log::debug('MANAGER SPECIALITY ID BY THERAPIST');
            $manager_speciality_group = DB::table('managers_specialities')->where('manager_id', $manager_id)->get();
            if ($manager_speciality_group != null && count($manager_speciality_group) > 0) {

                foreach ($manager_speciality_group as $managerSpecialityMatch) {
                    $currentManagerSpeciality = ManagerSpeciality::find($managerSpecialityMatch->manager_speciality_id);
                    if (
                        $currentManagerSpeciality != null &&
                        $currentManagerSpeciality->default
                    ) {
                        $manager_speciality_id = $currentManagerSpeciality->id;
                    }
                }
            }
        } else {
            Log::debug('MANAGER SPECIALITY ID BY USERS');
            $manager_speciality_id = $request->manager_speciality_id;
        }


        $booking = new Booking([
            "manager_id" => $manager_id,
            "project_id" => $project_id,
            "start" => $start,
            "end" => $end,
            "timekit_booking_id" => $timekit_booking_id,
            "when" => $when,
            "date_to_authorize" => $date_to_authorize,
            "bookable_id" => $bookable_id,
            "bookable_type" => $bookable_type,
            "app_source" => $app_source,
            "by_source" => $by_source,
            "paid_by" => $paid_by,
            "project_pricing_id" => $project_pricing_id,
            "manager_speciality_id" => ($manager_speciality_id != null) ? $manager_speciality_id : null
        ]);
        return $booking;
    }
    public function create_receipt_trait(Request $request)
    {
        // $customer_email = $request->customer_email;

        $booking_id = $request->booking_id;
        $request_date = Carbon::now();
        $requested_by = $request->requested_by;
        $requested_by_id = $request->requested_by_id;

        $booking = Booking::find($booking_id);

        //Create an email
        if ($booking != null) {

            $manager = Manager::find($booking->manager_id);

   
         
            //this is after sending the email
            $receipt = Receipt::create([
                "booking_id" => $booking_id,
                "request_date" => $request_date,
                "requested_by" => $requested_by,
                "requested_by_id" => $requested_by_id,
                "duplicated" => $duplicate
            ]);

            return json_encode($receipt);
        } else {
            Log::debug('oh look error');
            return "booking not available error";
        }
    }

    public function saveBookingPricing(Request $request)
    {
        $booking_id = $request->booking_id;
        $amount = $request->amount;
        $tax_amount = $request->tax_amount;
        $tip_amount = $request->tip_amount;
        $credit_card_amount = $request->credit_card_amount;
        $cash_amount = $request->cash_amount;
        $discount_amount = $request->discount_amount;
        $direct_billing_amount = $request->direct_billing_amount;
        $active = $request->active;

        $bookingPricing =  BookingPricing::Create([
            "booking_id" => $booking_id,
            "amount" => $amount,
            "tax_amount" => $tax_amount,
            "tip_amount" => $tip_amount != null,
            "credit_card_amount" => $credit_card_amount,
            "cash_amount" => $cash_amount,
            "discount_amount" => $discount_amount,
            "direct_billing_amount" => $direct_billing_amount,
            "active" => $active
        ]);
        return $bookingPricing;
    }

    public function getBookingPricingsByBookingIdTrait(Request $request)
    {
        $booking_id = $request->booking_id;
        $bookingPricings = BookingPricing::where([['booking_id', $booking_id], ['active', true]]);
        Log::debug('BOOKIONG RESULTS');
        Log::debug(json_encode($bookingPricings));
        return $bookingPricings;
    }

    public function cancelOrRescheduleChargeBookTrait(Request $request)
    {
        //TODO CANCELLATIONS FOR GUESTS
        $reason = $request->reason;
        $status_changed_by = $request->status_changed_by;
        $booking_id = $request->booking_id;
        $booking_status = $request->booking_status;
        $percentage_to_deduct = $request->percentage_to_deduct;
        $booking = Booking::find($booking_id);
        $user = User::find($booking->bookable_id); //this must be change to  auth
        $manager = Manager::find($booking->manager_id);


        //GETTING THE BOOKING PRICING
        $booking_pricing = BookingPricing::where('booking_id', $booking->id)->where('active', true)->first();
     
       //TODO: Who changed the status admin, therpaist or user
        $booking->status_changed_date = Carbon::today();
        $booking->status_changed_by = 'User';
        $booking->reason = $reason;
        $booking->booking_status = $booking_status;
        $booking->save();

        if ($booking_pricing != null && !$booking->closed) {
            Log::debug('PASSES CONDITION--------------------------------------------');
            //WE QUERY THE STRIPE_ID FROM BOOKING TRANSACTIONS, THE FIRST FROM THE LIST
            $bookingTx = BookingTransaction::where('booking_pricing_id', $booking_pricing->id)
                ->where('active', true)->first();
            Log::debug('BOOKING TRANSACTION');
            Log::debug($bookingTx);

            //WE CHECK IF IT REQUIRES FEE
            $startTime = $booking->start;
            Log::debug('START TIME');
            Log::debug($startTime);
             $cancellationTime = Carbon::now('UTC');
            // $cancellationTime = Carbon::create('2019-10-20 02:40:00', 'UTC');

            Log::debug('CANCELATION TIME');
            Log::debug($cancellationTime);
            $timeDifference = $cancellationTime->diffInMinutes($startTime);

            if ($timeDifference > 60 || $booking->paid_by==config('constants.configurations.paid_by_cash') ) {
                Log::debug('IS GREATER THAN 60 MINUTES');
                Log::debug($timeDifference);

                $amountToCharge =  0;
                $booking_pricing->active=false;
                $booking_pricing->save();

                //ADD INFO IN BOOKING PRICINGS
                $bookingPricing = BookingPricing::Create([
                    "booking_id" => $booking->id,
                    "amount" => 0,
                    "credit_card_amount" =>  0,
                    "active" => true
                ]);
                //return boolean charged
                return ([
                    "charged" => false
                ]);
            } else {
                Log::debug('IS LESS THAN 60 MINUTES');
                Log::debug($timeDifference);
                    

                    //STRIPE default CARD
                    $stripeDatas = Stripedata::find($bookingTx->stripedatas_id);
                       //CALCULATE AMOUNT TO CHARGE
                    $correctAmounts=$this->SpitOutCorrectAmounts($booking_pricing);
                    $price=floatval( $correctAmounts['amount'])+floatval( $correctAmounts['tax_amount']);
                    $amountToCharge =  $price * $percentage_to_deduct;

                    $currentCustomerUser['total_amount']=$amountToCharge;
                      //ADD INFO IN BOOKING PRICINGS
                    $booking_pricing->active=false;
                    $booking_pricing->save();
                    $bookingTx->active=false;
                    $bookingTx->save();
                    $bookingPricing = BookingPricing::Create([
                                "booking_id" => $booking->id,
                                "amount" => $amountToCharge,
                                "credit_card_amount" =>  $amountToCharge,
                                "active" => true
                            ]);
                          BookingTransaction::Create([
                                "booking_pricing_id" => $bookingPricing->id,
                                "stripedatas_id" => $stripeDatas->id,
                            ]);
                    $this->_postCreditCharges($bookingPricing,$booking,true);
                    Log::debug('AMOUNT To CHARGE');
                    Log::debug($amountToCharge);
        
                }
                return ([
                    "charged" => true
                ]);
            }
    }
    
}
