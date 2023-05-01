<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;


class TherapistProfileResource extends JsonResource
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
            "address"=>$this->address,
            "phone"=>$this->phone,
            "city"=>$this->city,
            "province"=>$this->province,
            "postal_code"=>$this->postal_code,
            "tag_line"=>$this->tag_line,
            "parking"=>$this->parking,
            "direct_billing"=>$this->direct_billing,
            "about"=>$this->about,
            "extra_information"=>$this->extra_information,
            "parking_description"=>$this->parking_description,
            "address_description"=>$this->address_description

             
         ];
    }
}
