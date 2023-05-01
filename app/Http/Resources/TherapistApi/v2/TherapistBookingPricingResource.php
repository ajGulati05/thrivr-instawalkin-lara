<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistBookingPricingResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     
        return [
           
            "amount"=>$this->amount,
            "tax_amount"=>$this->tax_amount,
            "tip_amount"=>$this->tip_amount,
            "discount"=>$this->discount_amount,
            "taxt_label"=>"GST 5%",
            "card_id"=>optional($this->topActiveBookingTransaction()->first())->stripedatas_id

         ];
    }
}
