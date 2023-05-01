<?php
namespace App\Http\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Twilio\Rest\Client; 
trait TwilioTrait
{

  public function sendSms( $number,$message )
    {
 
       // Your Account SID and Auth Token from twilio.com/console
       $sid    = env( 'TWILIO_SID' );
       $token  = env( 'TWILIO_TOKEN' );
       $t = new Client($sid,$token);
      $t->messages->create(
               $number,
               [
                   'from' => env( 'TWILIO_FROM' ),
                   'body' => $message,
               ]
           );
      
   }


public function massageBookSuccess($number,$notificationRequest){
Log::debug("Calling Twilio for Booking Success");

         $request = $notificationRequest[0];
        $responseGetBookingInfoResource = $request['responseGetBookingInfoResource'];


           $message = "You have a new massage appointment with ". $responseGetBookingInfoResource['customer_firstname'] .
           " at ".$responseGetBookingInfoResource['massage_time'] . "\n Details \n" .
       "Paid by " .$responseGetBookingInfoResource['payment_method']. "\n" .
       "Price ". $responseGetBookingInfoResource['project_pricing_amount']."\n" .
       "Tax". $responseGetBookingInfoResource['taxAmount']."\n" ;

        if(isset($responseGetBookingInfoResource['discountAmount']) && $responseGetBookingInfoResource['discountAmount']>0)
            {

            //    $message.= $responseGetBookingInfoResource['discountAmount']."\n" ." Total ".$responseGetBookingInfoResource['amountToPay']-$responseGetBookingInfoResource['discountAmount'];
              }
    else{
       $message.=    "Total ". $responseGetBookingInfoResource['amountToPay'] . "\n" ;
              
    }
   $message.='Thank you for using instawalkin.';
   $this->sendSms($number,$message);
      
}


public function massageBookCancellation($number,$notificationRequest){
Log::debug("Calling Twilio for Booking Cancellation");

         $request = $notificationRequest[0];
        $responseGetBookingInfoResource = $request['responseGetBookingInfoResource'];


           $message = "Your massage appointment with ". $responseGetBookingInfoResource['customer_firstname'] .
           " at ".$responseGetBookingInfoResource['massage_time'] . "has been cancelled. \n";
            if(isset($responseGetBookingInfoResource['amountToPay']) && $responseGetBookingInfoResource['amountToPay']>0)
            {
              $message.="A cancellation fee of " .$responseGetBookingInfoResource['cancellationFee']." CAD has been charged and will be credited to your account. \n" ;
            }
        $message.='Thank you for using instawalkin.';
       $this->sendSms($number,$message);
  }

public function massageBookReschedule($number,$notificationRequest){

}
}