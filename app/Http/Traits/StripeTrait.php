<?php

namespace App\Http\Traits;

use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use Cartalyst\Stripe\Exception\MissingParameterException;
use Cartalyst\Stripe\Exception\NotFoundException;
use App\Stripedata;
use App\BookingTransaction;
use App\Booking;
use App\Http\Traits\NotificationsTrait;
use App\Http\Traits\PriceCalculationTrait;
trait StripeTrait
{
    use NotificationsTrait;
    use PriceCalculationTrait;
    //THIS IS STILL IN CONSTRUCTION
    private $stripe;

    public function __construct()
    {
        $stripe_secret = config('services.stripe.secret');
        $stripe_version = config('services.stripe.version');

        $this->stripe = new Stripe($stripe_secret, $stripe_version);
    }

    public function _postCreditCharges($booking_pricing,$booking,$capture=false){
         $bookingTx = BookingTransaction::where('booking_pricing_id', $booking_pricing->id)->where('active', true)->first();
               Log::debug("he");
         Log::debug($booking);
         $actualBooking=Booking::where('id',$booking->id)->first();
          Log::debug($actualBooking);
                            $correctAmounts=$this->SpitOutCorrectAmounts($booking_pricing);
                         
                                    $stripeDatas = Stripedata::find($bookingTx->stripedatas_id);
                                    if ($stripeDatas != null) {
                                      
                                            try {
                                                 Log::debug("he");
                                              
                                                $charge = $this->_charge($correctAmounts,$stripeDatas,$capture);
                                                $bookingTx->charge_id = $charge['id'];
                                                $bookingTx->stripe_code_status_charge =$charge['status'];
                                                $bookingTx->stripe_reason_charge = $charge['status'];
                                                $bookingTx->save();
                                                if($capture)
                                                {   
                                                    $booking->closed=true;
                                                    $booking->save();
                                                }
                                                return $charge;
                                            } catch (MissingParameterException $e) {
                                                 Log::debug("MissingParameterException");
                                               $this->CustomMissingParameterException($e,$bookingTx,$booking);
                                  
                                            }
                                         catch (NotFoundException $e) { //it needs several exceptions
                                             Log::debug("NotFoundException");
                                         $this->CustomNotFoundException($e,$bookingTx,$booking);
                                           
                                        }
                                    
                                catch (StripeException $e) {
                                     Log::debug("StripeException");
                                     $this->StripeException($e,$bookingTx,$booking);
                                }
                                catch (Exception $e){
                                          Log::debug("StripeException");
                                }
                            }
    }
    public function _charge($pricing,$stripedatas,$capture_boolean=false)
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
        Log::debug($e);
         $code = $e->getCode();
            // Get the error message returned by Stripe
        $message = $e->getMessage();
            // Get the error type returned by Stripe
        $type = $e->getErrorType();
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

    public function CustomMissingParameterException(MissingParameterException $e, $bookingTransaction,$booking,$authorization=false){
            
            $code = $e->getCode();
            $message = $e->getMessage();
            $this->customExceptionHandler($bookingTransaction,$message ,$booking,$authorization);
          
    }

   public function CustomNotFoundException(NotFoundException $e,$bookingTransaction,$booking,$authorization=false){
           $code = $e->getCode();
            $message = $e->getMessage();
            $this->customExceptionHandler($bookingTransaction,$message ,$booking,$authorization);
    }

       public function CustomStripeException(StripeException $e,$bookingTransaction,$booking,$authorization=false){
           $code = $e->getCode();
            $message = $e->getMessage();
            $this->customExceptionHandler($bookingTransaction,$message ,$booking,$authorization);
    }

    public function customExceptionHandler($bookingTransaction,$message,$booking,$authorization=false)
    {
        if($authorization){
             $bookingTransaction->stripe_code_status_authorize = ($code != null) ? $code : '400';
                                    $bookingTransaction->stripe_reason_authorize = $message;
        }
        else{
               $bookingTransaction->stripe_code_status_charge = ($code != null) ? $code : '400';
                $bookingTransaction->stripe_reason_charge = $message; 
        }
    
        $bookingTransaction->save();
        $exceptionNotificationRequest =  new Request();
        $dataNotificationToUser['user_id'] = $booking->bookable_id;
        $dataNotificationToUser['error'] = $message;
        $dataNotificationToUser['card_id'] = 'test';
        $exceptionNotificationRequest->data = $dataNotificationToUser;
        $exceptionNotificationRequest->reason = config('constants.notifications.notification_credit_card_error');
        $this->sentExceptionNotificationToSupport($exceptionNotificationRequest);

    }
}
