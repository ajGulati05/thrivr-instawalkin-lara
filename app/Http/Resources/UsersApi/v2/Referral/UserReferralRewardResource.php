<?php

namespace App\Http\Resources\UsersApi\v2\Referral;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class UserReferralRewardResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           
                'reward'=>$this->debit,
                'consumed_rewards'=>$this->credit,
                'reward_text'=>'Get $10 off your next massage'

            ];
    }
}




 