<?php

namespace App\Observers;
use Illuminate\Http\Request;
use App\User;
use App\UserNotifications;
use App\Userprofile;
use App\RewardEmail;
use Illuminate\Support\Facades\Log;
use App\UserReward;
use App\RewardHistory;
use App\Services\Rewards\UserRewardService;
use App\Notifications\ReferralUpdateNotification;
use Carbon\Carbon;
use App\Notifications\UserUsePromoCodeNotification;
class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */

    protected $request;

        public function __construct(Request $request)
        {
            $this->request = $request;
        }
    public function created(User $user)
    {
        //send a user to use promo code notification if they have not created a booking after signing up
       //TODO user notification with new code

        // $user->notifyAt(new UserUsePromoCodeNotification(), Carbon::now()->addMinutes(120));
        //send a user a notification to invite people
        $user->notifyAt(new ReferralUpdateNotification(), Carbon::now()->addDays(2));
         $this->createUserNotifications($user);
         $this->updateRewardEmailTable($user);
          $this->createRewards($user);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    public function createUserNotifications(User $user){
        $user->usernotifications()->create();
   }



  public function updateRewardEmailTable(User $user){

   
    if(!is_null($user->referred_by)){
        //IF TABLE EXISTS
         $rewardee=$user->rewardee;
       
    if(RewardEmail::where([['email',$user->email],['user_id',$rewardee->id]])->exists())
    {
        $rewardEmail=RewardEmail::where([['email',$user->email],['user_id',$rewardee->id]])->first();
        $rewardEmail->accepted=true;
        $rewardEmail->save();
    }


}
  }



    public  function createRewards(User $user){

        $userRewardService= new UserRewardService();
        $userRewardService->setRewards($user);
    }

}
