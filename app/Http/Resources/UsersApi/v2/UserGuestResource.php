<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class UserGuestResource extends JsonResource
{

 
    public function toArray($request)
    {

   
   
        return [
        	"id"=>$this->id,
            "fullname"=>$this->name
            ];
    }
}
