<?php

namespace App\Observers;

use App\RewardEmail;
use App\Notifications\UserReferralInviteNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class RewardEmailObserver
{
    /**
     * Handle the reward email "created" event.
     *
     * @param  \App\RewardEmail  $rewardEmail
     * @return void
     */
    public function created(RewardEmail $rewardEmail)
    {

          $rewardEmail->notify(new UserReferralInviteNotification(Auth::user()->firstNameValue));
          $rewardEmail->notifyAt(new UserReferralInviteNotification(Auth::user()->firstNameValue),Carbon::now()->addDays(7));
    }

   
}
