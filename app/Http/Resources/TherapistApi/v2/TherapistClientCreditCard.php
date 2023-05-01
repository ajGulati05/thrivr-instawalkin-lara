<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TherapistClientCreditCard extends JsonResource
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
            
            'default_card'=>$this->default_card,
            'title'=>$this->card_brand.' '.$this->card_last_four,
            'id'=>$this->id,
           

             
         ];
    }
}
