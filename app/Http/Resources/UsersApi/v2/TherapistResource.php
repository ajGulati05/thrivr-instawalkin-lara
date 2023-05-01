<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonResources\v2\ManagerSpecialitiesResource;

class TherapistResource extends JsonResource
{


    public function toArray($request)
    {



        return [
            "manager_id"=>$this->id,
            "timekit_resource_id"=>$this->timekit_resource_id,
            "manager_first_name"=>$this->first_name,
            "manager_last_name"=>$this->last_name,
            "gender"=>$this->gender,
            "business_name"=>$this->business_name,
            "slug"=>$this->slug,
            "tag_line"=>optional($this->manager_profiles)->tag_line,
            "parking"=>optional($this->manager_profiles)->parking,
            "profile_photo"=>config('app.s3_bucket_address').$this->profile_photo,
            "direct_billing"=>optional($this->manager_profiles)->direct_billing,
             "taking_clients"=>optional($this->manager_profiles)->taking_clients,
            "manager_specialities"=>ManagerSpecialitiesResource::collection($this->manager_specialities),
            "distance"=>round(optional($this->manager_profiles)->distance),
            "address"=>optional($this->manager_profiles)->address,
            "address_description"=>optional($this->manager_profiles)->address_description,
            "postal_code"=>optional($this->manager_profiles)->postal_code,
            "city"=>optional($this->manager_profiles)->city,
            "phone"=>optional($this->manager_profiles)->phone,
            "rating"=>$this->reviewScore(),
            "review_count"=>$this->reviewCount(),
            "availability"=>$this->availability,
            "product_code"=>$this->product_code,
            "about_therapist"=>optional($this->manager_profiles)->about,
            "mini_avatar"=>config('app.s3_bucket_address').$this->mini_avatar,
            "mini_avatar_attributes"=>$this->mini_avatar_attributes,
            "avatar_attributes"=>$this->avatar_attributes,
            "show_reviews"=>$this->show_reviews?true:false,
            "position"=>optional($this->manager_profiles)->position,
            ];
    }
}
