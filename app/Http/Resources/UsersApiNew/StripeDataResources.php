<?php

namespace App\Http\Resources\UsersApiNew;

use Illuminate\Http\Resources\Json\JsonResource;

class StripeDataResources extends JsonResource
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
            'id'=>$this->id,
            'stripe_id'=>$this->stripe_id,
            'card_token'=>$this->card_token,
            'default_card'=>$this->default_card,
            'card_brand'=>$this->card_brand,
            'card_last_four'=>$this->card_last_four,
            'title'=>$this->card_brand.' '.$this->card_last_four,
            'orderby'=>$this->id,
            'stripedatas_id'=>$this->id,
            'paid_by'=>'CR' // IF ITS NATIVE PAY THEN NATIVE?
        ];
    }
}
