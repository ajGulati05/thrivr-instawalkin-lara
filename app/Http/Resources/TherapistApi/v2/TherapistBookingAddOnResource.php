<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistBookingAddOnResource extends JsonResource
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
          'sub-description'=>$this->subModalties->description,
          'minutes'=>$this->subModalties->minutes,
          'price'=>$this->amount,
          'tax'=>$this->tax_amount,
          'total'=>$this->amount+$this->tax_amount,
          'active'=>$this->active
         ];
    }
}



