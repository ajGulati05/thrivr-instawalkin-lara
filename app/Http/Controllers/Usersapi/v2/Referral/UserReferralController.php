<?php

namespace App\Http\Controllers\Usersapi\v2\Referral;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersApi\v2\Referral\UserReferralRewardListResource;
use App\Http\Resources\UsersApi\v2\Referral\UserReferralRewardResource;

class UserReferralController extends Controller
{

   public function rewardsList(){
        $user=Auth::user();
     $data=$user->load('rewardHistories.rewardee');
     $read=true;

      if($data->rewardHistories()->where('read',0)->exists())
      {
        $read=false;
      }


      return response()->json(["data"=> ['list'=>UserReferralRewardListResource::collection($data->rewardHistories),'read'=>$read],"status"=>true ],200);
        
   }

     public function totalRewards(){
        $rewards=Auth::user()->load('rewards');
      
        return response()->json(["data"=>new UserReferralRewardResource($rewards->rewards),"status"=>true],200);

       // $user->rewardHistory

        
   }
}
