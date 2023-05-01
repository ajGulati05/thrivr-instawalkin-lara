<?php

namespace App\Http\Resources\UsersApi\v2\Referral;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class UserReferralRewardListResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           
                'reward'=>$this->reward,
                'pending'=>$this->pending,
                'name'=>$this->rewardee->fullName,
                'date'=>Carbon::parse($this->created_at,'UTC')->isoFormat('MMM Do, YYYY'),
                'read'=>$this->read
            ];
    }
}




 