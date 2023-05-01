<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistSplitBookingPricingResource extends JsonResource
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
           "amount_1"=>$this->amount_1,
            "amount_2"=>$this->amount_2,
           
         ];
    }
}
