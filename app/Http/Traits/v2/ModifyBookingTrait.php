<?php

namespace App\Http\Traits\v2;

use App\Booking;
use App\BookingPricing;
use App\BookingTransaction;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\v2\PriceCalculationTraitV2;
use App\User;
use Illuminate\Support\Facades\Auth;

trait ModifyBookingTrait
{
  
use PriceCalculationTraitV2;


  //A booking can be canceled by the user or rescheduled 
  // A booking cancelled or reschduled is only charged if its less than 60 minutes left to the appointment


    public function isLessThan60MinutesToTheAppointment(Booking $booking){
             $startTime = $booking->start;
             $modifyTime = Carbon::now('UTC');
             $minuteDifference = $modifyTime->diffInMinutes($startTime);

             if($minuteDifference>60)
             {
              return false;
             }

             return true;
           
    }

    public function isLessThan24hoursToTheAppointment(Booking $booking){
        $startTime = $booking->start;
        $modifyTime = Carbon::now('UTC');
        $hourDIfference = $modifyTime->diffInHours($startTime);

        if($hourDIfference>24)
        {
         return false;
        }

        return true;
      
    }

    public function isLessThan15MinutesAfterAppointmentCreation(Booking $booking){
        $createdTime = $booking->created_at;
        $modifyTime = Carbon::now('UTC');
        $minuteDIfference = $modifyTime->diffInMinutes($createdTime);

        if($minuteDIfference > 15){
            return false;
        }

        return true;
    }


    public function getAmountToBeCharged(BookingPricing $BookingPricing,$percentage_to_deduct)
    {               
                    $correctAmounts=$this->SpitOutCorrectAmounts($BookingPricing);
                    $price=floatval( $correctAmounts['amount'])+floatval( $correctAmounts['tax_amount']);
                    $amountToCharge =  $price * $percentage_to_deduct;
                    return $amountToCharge;
    }

   

    public function rescheduleBooking(Request $request, Booking $booking){

    }

    public function updateBooking(Request $request,Booking $booking,$modifiedby){



        $booking->update([
                "status_changed_by"=>$modifiedby,
                "booking_status"=>request('modifier'),
                "status_changed_date"=>Carbon::now(),
                "reason"=>request('modifier'),
                "closed"=>1
        ]);
      
        $this->updateBookingPricing($request,$booking,$modifiedby);
                
         return $booking->load('manager.profiles','managerSpeciality','activeBookingPricing.topActiveBookingTransaction.stripedatas');

    }


    public function updateBookingPricing(Request $request, Booking $booking,$modifiedBy){
        
        $bookingPricing=$booking->topActiveBookingPricing();
        $amountToBeCharge = request('amount_to_be_charged')==0?null:request('amount_to_be_charged');
        //close the original booking if there is a price request 
        $bookingPricingCopy = $bookingPricing->replicate();
        $bookingPricingCopy->amount = $amountToBeCharge;
        $bookingPricingCopy->amount_1 =$amountToBeCharge;
        $bookingPricingCopy->tax_amount =null;
        $bookingPricingCopy->tip_amount =null;
        $bookingPricingCopy->discount_amount =null;
        $bookingPricingCopy->active =true;

        $bookingPricing->active=false;
        $bookingPricing->save();
        $bookingPricingCopy->save();
        if($modifiedBy == Booking::BOOKED_BY_USER){
            //copy the old booking 
            if($booking->paid_by=='CR'){
                return $this->updateBookingTransaction($bookingPricing,$bookingPricingCopy);
            }
            // if booking payment method is not credit card, but has a amount to be charged
            else if(request("amount_to_be_charged")){
                // Create bookingTransaction to cover rescheduling/cancelation fees
                $user  = Auth::user();
                $defaultCreditCard =$user->creditcards()->withTrashed()->where('default_card',true)->first();
                if($defaultCreditCard){
                    $newTransaction = new BookingTransaction();
                    $newTransaction->booking_pricing_id = $bookingPricingCopy->id;
                    $newTransaction->stripedata_id =$defaultCreditCard->id ;
                    $newTransaction->active = true; 
                    $newTransaction->save();
                }else{
                    // Notify that there is a amount to be charge but we don't have a credit card to do so.
                    Log::critical('Cancelation/Rescheduling has a amount to be charge but no credit card is available. Booking id: '.$booking->id
                        ." || Booking Pricing Id: {$bookingPricingCopy->id}"
                        ." || Amount to be charge: {$request->amount_to_be_charged}"
                        ." || User name: {$booking->bookable->fullName}"
                        ." || User email: {$booking->bookable->email}");
                }
            }
        
        }

        return true;
    }

    public function updateBookingTransaction(BookingPricing $oldBookingPricing, BookingPricing $newBookingPricing){
        //deactivate the old transaction
        $oldBookingTransaction= $oldBookingPricing->firstActiveBookingTransaction();
        Log::debug($oldBookingTransaction);
        $newBookingTransaction=$oldBookingTransaction->replicate();
        $oldBookingTransaction->active=false;
        $oldBookingTransaction->save();
        $newBookingTransaction->active=true;
        $newBookingTransaction->booking_pricing_id=$newBookingPricing->id;
        $newBookingTransaction->save();
        return $newBookingTransaction;

    }


    public function confirmModifyBooking(Request $request, Booking $booking,$modifiedby){
            //if a booking has no recourse then just cancel booking or reschedule it
     
       $booking= $this->updateBooking($request,$booking,$modifiedby);


       return $booking;
    }

    public function modifyBooking(Request $request, Booking $booking,$modifiedby)
    {   

        $user = Auth::user();

        if($user instanceof User){
            $userStripeData = $user->stripedata()->withTrashed()->where('default_card',true)->first();
        }
      
        // Add cancelation/rescheduling fees if all of the above applies:
        // * the modification is being done 24 hours before the booking starts and has passed 15 minutes after creating the booking
        // * the booking payment method is a credit card or the user was forced to add a credit card before creating the booking (change introduced on 2021-08-29)
        if( $modifiedby == Booking::BOOKED_BY_USER && $this->isLessThan24hoursToTheAppointment($booking) && !$this->isLessThan15MinutesAfterAppointmentCreation($booking) 
            && !blank($userStripeData))
        {  
            $status_changed_by = $modifiedby;
            $percentage_to_deduct = request('modifier')=='C'?Booking::CANCEL_FEE_PERCENTAGE:Booking::RESCHEDULE_FEE_PERCENTAGE;
            $booking_status = request('modifier');

            $bookingActivePricing=$booking->topActiveBookingPricing();
            $amountToCharge=$this->getAmountToBeCharged($bookingActivePricing,$percentage_to_deduct);
            $modiferTextToUser=request('modifier')=='C'?"cancelling":"rescheduling";
            $modifierTextToUseShort=request('modifier')=='C'?"cancel":"reschedule";
          
           return ["message"=>"Are you sure you want to " .$modifierTextToUseShort." this booking? You will be charged $".$amountToCharge.' for '.$modiferTextToUser." within 24 hours left to your appointment.","amount-to-be-charged"=>$amountToCharge,'percentage_to_detuct'=> $percentage_to_deduct ]; 
        }
        else{
            $modifierTextToUseShort=request('modifier')=='C'?"cancel":"reschedule";
            return ["message"=>"Are you sure you want to " .$modifierTextToUseShort." this booking?","amount-to-be-charged"=>0,'percentage_to_detuct'=> 0 ];
        }   



           
    }
    
}
