<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\TherapistApi\v2\TherapistClientCreditCard;
class TherapistClientResource extends JsonResource
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
            
            "name"=> $this->fullName,
            "firstname"=>$this->profiles->firstname,
            "lastname"=>$this->profiles->lastname,
            "phone"=>$this->profiles->phone,
            "email"=>$this->email,
            "avatar"=>!$this->profiles->avatar?null:config('app.s3_bucket_address').$this->profiles->avatar,
            "id"=>'User:'.$this->instauuid,
            "blocked"=>optional($this->pivot)->blocked==0?false:true,
            "editable"=>false,
            "guest"=>false,
          "creditcards"=> TherapistClientCreditCard::collection($this->creditcards)

             
         ];
    }
}
