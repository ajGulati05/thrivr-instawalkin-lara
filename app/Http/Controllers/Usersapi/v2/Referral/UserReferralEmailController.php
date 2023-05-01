<?php

namespace App\Http\Controllers\Usersapi\v2\Referral;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class UserReferralEmailController extends Controller
{

   public function invite(Request $request){

    Log::debug("hello");
        $user=Auth::user();
         $request->validate([
        'name'=>'required|string',
        'email' => 'required|string|email|max:255|unique:reward_emails'
    ]);


$rewardEmail = $user->rewardEmails()->create([
  'name'=>request('name'),
  'email'=>request('email')
]);
     
       
    return response()->json(["message"=>"The user has been emailed.","status"=>true],200);
        
   }


}
