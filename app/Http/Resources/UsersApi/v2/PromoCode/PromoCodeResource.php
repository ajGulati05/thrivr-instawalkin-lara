<?php

namespace App\Http\Resources\UsersApi\v2\PromoCode;

use Illuminate\Http\Resources\Json\JsonResource;


class PromoCodeResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           
            
            
             "code"=>$this->code,
             "reward"=>$this->reward,
            "currency"=>$this->data["currency"],
     
            ];
    }
}




 