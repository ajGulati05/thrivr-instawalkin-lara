<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReferralRewardClass 
{
    //debit is how many rewards a user has
    //credit is how many rewards a user has used

//When a reward is consumed
public function consumeReward($user,$reward){
    $userRewards=$user->rewards;
    $userRewards->update([
        'debit'=>$userRewards->debit - $reward,
        'credit'=>$userRewards->credit + $reward

    ]);
}

//When a reward is unconsumed
    public function unconsumeReward($user,$reward){
        $userRewards=$user->rewards;
        $userRewards->update([
            'debit'=>$userRewards->debit + $reward,
            'credit'=>$userRewards->credit - $reward

        ]);
    }

//when a reward is given
public function apply($user,$reward)
    {

        $userRewards=$user->rewards;
        $userRewards->update([

            'debit'=>$userRewards->debit + $reward

        ]);
       }

      

        //update reward history
        
    

    public function remove($user,$reward){
        $userRewards=$user->rewards;

        $userRewards->update([
            'debit'=> $userRewards->debit -$reward,


        ]);

    }



    


}
   