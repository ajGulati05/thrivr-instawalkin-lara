<?php

namespace App\Http\Resources\UsersApiNew;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfiles extends JsonResource
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
            'email'=>$this->email,
            'push_token'=>$this->expo_token,
            'firstname'=>$this->userprofiles->firstname,
            'lastname'=>$this->userprofiles->lastname,
            'phone'=>$this->userprofiles->phone,
            'avatar'=>empty($this->userprofiles->provider)?empty($this->userprofiles->avatar)?null:config('app.s3_bucket_address').$this->userprofiles->avatar:$this->userprofiles->avatar,
            'uuid'=>$this->instauuid,
            'verified_at'=>$this->email_verified_at,
            'referral_link'=>config('constants.urls.webapp').'/signup?referral='.$this->affiliate_id,
            'referral_code'=>$this->affiliate_id,
            'require_credit_card'=>$this->forceRequireCreditCard()
        ];
    }
}
