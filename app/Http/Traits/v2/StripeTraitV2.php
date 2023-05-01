<?php

namespace App\Http\Traits\v2;

use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use Cartalyst\Stripe\Exception\MissingParameterException;
use Cartalyst\Stripe\Exception\NotFoundException;
use App\Stripedata;
use App\BookingTransaction;
use App\Booking;

use App\Http\Traits\v2\PriceCalculationTraitV2;
trait StripeTraitV2
{
   
    use PriceCalculationTraitV2;
    //THIS IS STILL IN CONSTRUCTION
    private $stripe;

    public function __construct()
    {
        $stripe_secret = config('services.stripe.secret');
        $stripe_version = config('services.stripe.version');

        $this->stripe = new Stripe($stripe_secret, $stripe_version);
    }




    public function _postCreditCharges($booking,$capture=false){
          
          $booking_pricing=$booking->firstActiveBookingPricing();
          $bookingTx=$booking->firstActiveBookingPricing()->firstActiveBookingTransaction();
          $correctAmounts=$this->SpitOutCreditAmounts($booking_pricing);
          $stripeDatas = Stripedata::find($bookingTx->stripedatas_id);
                              

                                    if ($stripeDatas != null) {

                                        try {


                                            $charge = $this->_charge($correctAmounts, $stripeDatas,$booking, $capture);
                                            $bookingTx->charge_id = $charge['id'];
                                            $bookingTx->stripe_code_status_charge = $charge['status'];
                                            $bookingTx->stripe_reason_charge = $charge['status'];
                                            $bookingTx->save();
                                            if ($capture) {
                                                $booking->closed = true;
                                                $booking->save();
                                            }
                                            return $charge;
                                        } catch (Exception $e) {
                                            Log::critical('exception' . $e);
                                        }
                                    }
                                else{
                                    Log::critical('Cannot process payment for Booking'.$booking->id);
                                    }

    }
    

    public function _charge($pricing,$stripedatas,$booking=null,$capture_boolean=false)
    {
        

        $amountToCharge = $pricing['total_amount'];
        $charge = $this->stripe->charges()->create([
                'customer' => $stripedatas->stripe_id,
                'currency' => 'CAD',
                'amount'   => $amountToCharge,
                'source' => $stripedatas->card_token,
                'capture' => $capture_boolean,

            ]);
          
            return $charge;
    }


public function _capture($charge_id){
    try {
            return  $this->stripe->charges()->capture($charge_id);
         }
     catch (StripeException $e) {
        Log::critical("Stripe Capture {$charge_id}" .$e->getMessage());
    
    }
}
     public function _createCustomer($email)
        {
        
                return $this->stripe->customers()->create([
                'email' => $email
            ]);

        }
    public function _createCard($id,$card_token)
        {
        
                return $this->stripe->cards()->create($id, $card_token);

        }

    public function _find($stripe_id)
        {
        
               return $this->stripe->customers()->find($stripe_id);

        }


        public function _update($customer_id,$data){
            return $this->stripe->customers()->update($customer_id,$data);
        }

 
}
