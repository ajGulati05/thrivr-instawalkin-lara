<?php

namespace App\Http\Controllers\UserApiController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
//use JWTAuthException;
use Illuminate\Support\Facades\Validator;
use App\Transactions;
 use App\Http\Resources\UsersApi\UserHistory;
use Illuminate\Support\Facades\Log;
class UserHistoryController extends Controller
{
    //

    public function __construct()
    {
        //$this->middleware('jwt-auth');

    }

    public function getUserHistory(){


    $token = JWTAuth::getToken();
    Log::error("hellp".$token);
    $user = JWTAuth::toUser($token);

  $userhistory= Transactions::where('user_id', $user->id)->accepted()->get();
  $returnVal=  UserHistory::collection($userhistory)->keyBy('id');  
    return $returnVal;
       //$usersprofile= $user->userprofiles;
        //return response()->json(['error'=>'false','usersprofile'=>$usersprofile,'code'=>'200'],200);
    }

    public function getRecentUnreadHistory(){
    $token = JWTAuth::getToken();
    Log::error("hellp".$token);
    $user = JWTAuth::toUser($token);

      //get top history thats unread..
      //change it to read
      //and send it back 

  $userhistory= Transactions::where('user_id', $user->id)->unread()->take(1)->orderBy('id','desc')->get();
  $returnVal=  UserHistory::collection($userhistory)[0];  
    return $returnVal;
    }
}
