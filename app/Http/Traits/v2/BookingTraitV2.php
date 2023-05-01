<?php

namespace App\Http\Traits\v2;

use App\Booking;
use App\BookingPricing;
use App\BookingStatusCode;
use App\BookingTransaction;
use App\ManagerSpeciality;
use App\Project;
use App\ProjectPricing;
use App\Receipt;
use App\Stripedata;
use App\User;
use App\BookingAddOn;
use App\SubModalitie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


use App\Helpers\PromoCodeClass;
use Notification;
use App\Http\Traits\NotificationsTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Extensions\CustomPromocode;
use App\Helpers\ReferralRewardClass;
trait BookingTraitV2
{
  
    use NotificationsTrait;
 
    public function createBookingOnDatabase(Request $request)
    {
      
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
        $manager_speciality_id = $request->manager_speciality_id;
       

        $booking = new Booking([
            "manager_id" => $manager_id,
            "project_id" => $project_id,
            "start" => $start,
            "end" => $end,
            "timekit_booking_id" => $timekit_booking_id,
            "when" => $when,
            "date_to_authorize" => $date_to_authorize,
            "app_source" => $app_source,
            "by_source" => $by_source,
            "paid_by" => $paid_by,
            "project_pricing_id" => $project_pricing_id,
            "manager_speciality_id" => ($manager_speciality_id != null) ? $manager_speciality_id : null,
            "userguest_id"=>request("userguest_id"),

        
        ]);
       
        return $booking;
    }


    public function resolveDiscount($promo_code){
    Log::debug($promo_code);
        $user=Auth::user();
             $coupon_amount=null;
        if($user instanceof User)
        {


        $promoCodeHelper=new PromoCodeClass();

        $referralRewardClass=new ReferralRewardClass();
    
        //if user has reward apply reward

        //referral
        if($user->rewards->debit>0){
            
            $coupon_amount=$user->rewards->debit;
            $referralRewardClass->consumeReward($user,$coupon_amount);
        }
        //if the request has promo code apply the promo code
        if(!is_null($promo_code)){
        
           $promoCodeValues= $promoCodeHelper->runPromoCodeCheck($promo_code);
           CustomPromocode::apply($promo_code);
           $coupon_amount= $promoCodeValues->reward;

        }
}
       return $coupon_amount;


    }

    public function createBookingPricingOnDatabase($project,$promo_code){
       
                $project_pricing_amount = $project->activeprojectpricing[0]->amount;
                $coupon_amount=$this->resolveDiscount($promo_code);
                //GET TAXES VALUES
                $totalTaxes = $project->activeprojectpricing[0]->calculatetax->sum('taxpercent');

                if (is_null($totalTaxes) || $totalTaxes <= 0) {
                    $tax_amount = 0;

                    //CALCULATION OF TAX AMOUNT
                } else {
                    $tax_amount = ($totalTaxes / 100) * $project_pricing_amount;
                }


    $bookingPricing =  new BookingPricing([
        
            "amount" => $project_pricing_amount,
            "tax_amount" => $tax_amount,
            "tip_amount" =>null,
            "amount_1"=>$project_pricing_amount+$tax_amount,
           // "credit_card_amount" => $credit_card_amount,
          
            "discount_amount" => $coupon_amount,
         
            "active" => true
        ]);
                   
                return $bookingPricing;
    }

 public function createBookingAddOns(Booking $booking,  $subModalitie){
            $subdModalities=explode(',', $subModalitie);
            foreach($subdModalities as $subModaltitieItem){
                        Log::debug($subModaltitieItem);
                        $subModaltiedModelPricing=SubModalitie::find($subModaltitieItem);
                          $amount=null ;
                        $taxAmount= null;
                       if($subModaltiedModelPricing->subModalitiesPricings()->exists()){
                          $amount=10;//$subModaltiedModelPricing->subModalitiesPricings->price ;
                        $taxAmount= 5;
                       }
                      
                          $bookingAddons =  new BookingAddOn([
                                         "sub_modalities_code" => $subModaltitieItem,
                                         "tax_amount" =>$taxAmount,
                                         "amount" =>$amount ,
                                         "active" => true
        ]);       
                    $booking->bookingAddOns()->save($bookingAddons);
                    }

 }   

    public function createBookingTransactionOnDatabase($bookingPricing,$credit){
               //Booking transactions table
                      
                            BookingTransaction::Create([
                                "booking_pricing_id" => $bookingPricing->id,
                                "stripedatas_id" => $credit,
                            ]);

    }



public function nextBooking($client){
      $next24Hours = Carbon::now()->addHours(24)->toDateTimeString();
         $prev24Hours=Carbon::now()->addHours(-24)->toDateTimeString();

       $nextBooking= $client->books()
        ->whereNull('booking_status')
        ->whereBetween('start',[$prev24Hours,$next24Hours])
        ->where('closed',false)
        ->orderBy('start')
        ->first();
        return $nextBooking;
}
    
}
