<?php

namespace App\Http\Traits;

use App\BookingPricing;


trait PriceCalculationTrait
{
    //THIS IS STILL IN CONSTRUCTION
    public function SpitOutCorrectAmounts(BookingPricing $bp)
    {
        $amount=$bp->amount==null?0:$bp->amount;
        $tax_amount=$bp->tax_amount==null?0:$bp->tax_amount;
        $tip_amount=$bp->tip_amount==null?0:$bp->tip_amount;
        $discount_amount=$bp->discount_amount==null?0:$bp->discount_amount;
        //tax_amount
        //tip_amount
        //credit_card_amount
        //discount_amount
        //cash_amount
        //direct_billing_amount
       $total_amount= $amount + 
        $tax_amount + 
        $tip_amount-
        $discount_amount;
       
        // first case -- Amount plus Tax
        // Second Case -- Amount Plus Tax plus Tip 
        // Third Case -- Amount Plus Tax plus Tip Plus Discount
        // Case base on cash based on credit

        $currentCustomerUser['total_amount']=$total_amount;
        $currentCustomerUser['amount']=$amount;
        $currentCustomerUser['tax_amount']=$tax_amount;
        $currentCustomerUser['tip_amount']=$tip_amount;
        $currentCustomerUser['discount_amount']=$discount_amount;

        return $currentCustomerUser;

    }


}
