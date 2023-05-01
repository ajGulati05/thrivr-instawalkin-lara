<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardResource extends JsonResource
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
            'default_card'=>$this->default_card,
            'card_brand'=>$this->card_brand,
            'card_last_four'=>$this->card_last_four,
           
        ];
    }
}
