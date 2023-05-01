<?php

namespace App\Http\Resources\UsersApi\v2;
use Illuminate\Http\Resources\Json\JsonResource;


class UserSplitBookingPricingResource extends JsonResource
{

 
    public function toArray($request)
    {

    
 return [
           "amount_1"=>$this->amount_1,
            "amount_2"=>$this->amount_2,
           
         ];
    }
}




 