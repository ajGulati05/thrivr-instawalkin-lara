<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class ManagerSpecialitiesResource extends JsonResource
{

 
    public function toArray($request)
    {

    
        return [
            "id"=>$this->id,
            "code"=>$this->code,
            "description"=>$this->description,
            "long_description"=>$this->long_description,
            "image_path"=>config('app.s3_bucket_address').$this->speciality_photo,
            "default"=>$this->default,
            "image_attributes"=>$this->speciality_photo_attribute

            ];
    }
}
