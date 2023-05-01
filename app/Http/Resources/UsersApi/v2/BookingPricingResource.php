<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UsersApi\TherapistResource;

class BookingPricingResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           
       			
            
             "tax_amount"=>$this->tax_amount,
             "taxlabel"=>'GST 5%',
             "discount"=>$this->discount_amount,
             "massage_price"=>$this->amount,
             "tip_amount"=>$this->tip_amount
           //  "card"=>optional($this->active_booking_transactions[0]->stripedatas)->card_brand)
            ];
    }
}




 