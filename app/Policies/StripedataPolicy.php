<?php

namespace App\Policies;
use Illuminate\Auth\Access\Response;
use App\User;
use App\Stripedata;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;
class StripedataPolicy
{
    use HandlesAuthorization;
 

 public function destroy(User $user, Stripedata $stripedata)
    {
        //TODO CHECK IF THE CARD WAS USED FOR A RECENT MASSAGE AND HAS NOT BEEN CHARGED YET
        return $user->id === $stripedata->user_id
         ? Response::allow()
                :abort(response()->json(["message"=>'You do not own this credit card.',"status"=>false,"errors"=>"You do not own this credit card."],403));
    }
   public function default(User $user, Stripedata $stripedata)
    {
        return $user->id === $stripedata->user_id
         ? Response::allow()
                :abort(response()->json(["message"=>'You do not own this credit card.',"status"=>false,"errors"=>"You do not own this credit card."],403));
    }  

  public function canUse(User $user, Stripedata $stripedata)
    {
        return $user->id === $stripedata->user_id
         ? Response::allow()
                :abort(response()->json(["message"=>'You do not own this credit card.',"status"=>false,"errors"=>"You do not own this credit card."],403));
    }  

}
