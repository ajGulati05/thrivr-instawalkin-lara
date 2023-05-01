<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TherapistApi\TherapistProfileResource;
class TherapistResource extends JsonResource
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
            "gender"=>$this->gender,
            "firstname"=>$this->first_name,
            "lastname"=>$this->last_name,
            "gender"=>$this->gender,
            "business_name"=>$this->business_name,
            "therapist_bio"=>new TherapistProfileResource($this->profiles),
            "product_code"=>$this->product_code,
            "avatar"=>config('app.s3_bucket_address').$this->profile_photo,
            "hasInitiallyUpdated"=>$this->first_login,
            "active"=>$this->status,
            "skip"=>$this->skip,
            "timezone"=>$this->timezone
             
         ];
    }
}
