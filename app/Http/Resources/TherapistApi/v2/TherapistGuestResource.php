<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistGuestResource extends JsonResource
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

          "name"=>$this->fullName,

            "firstname"=>$this->firstname,
            "lastname"=>$this->lastname,
            "phone"=>$this->phone,
            "email"=>$this->email,
            "id"=>'Guest:'.$this->instauuid,
            "verifed"=>isset($this->email_verified_at)?true:false,
            "editable"=>true,
            "guest"=>true
           
             
         ];
    }
}
