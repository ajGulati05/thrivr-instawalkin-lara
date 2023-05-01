<?php

namespace App\Services\Rewards;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\User;
use App\UserReward;


class UserRewardService
{



    public function setRewards(User $user)
    {
        //set the rewards of the user invited
        $this->inviteeRewards($user);


        if (!is_null($user->referred_by)) {
            $this->rewardeeRewards($user->rewardee, $user);
        }
    }

    public function inviteeRewards(User $user)
    {
        //if a user is signing in without referral they get nothing just create a null account for them
        if (!is_null($user->referred_by)) {




                //if it does not we are creating a record
                $user->rewards()->create([
                    'debit' => UserReward::INVITEE_REWARD,
                ]);


            $rewardee_id = $user->rewardee;


            $user->rewardHistories()->create(
                [
                    'rewardee_id' => $rewardee_id->id,
                    'reward' => UserReward::INVITEE_REWARD

                ]

            );
            //Create or Update reward for User
            //Create history for user PENDING is false


            //Create or Update reward


        } else {
            //if no referral just create a rewards record
            $user->rewards()->create();
        }
    }


    public function rewardeeRewards(User $user, User $fromUser)
    {

        //person who sent the referral

        $user->rewardHistories()->create(
            [
                'rewardee_id' => $fromUser->id,
                'reward' => UserReward::REWARDEE_REWARD,
                'pending' => true

            ]

        );

    }

}



 