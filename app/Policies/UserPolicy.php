<?php

namespace App\Policies;
use Illuminate\Auth\Access\Response;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class UserPolicy
{
    use HandlesAuthorization;
 

 public function doesTheUserHaveAnEmail(User $user)
    {
      
        return !empty($user->email)
         ? Response::allow()
                :abort(response()->json(["message"=>'You need an email to proceed.',"status"=>false,"errors"=>"You need an email to proceed.","callback"=>"email-required"],403));
    }

 public function canTheUserUpdatePassword(User $user)
    {
      
        return empty($user->provider)
         ? Response::allow()
                :abort(response()->json(["message"=>'You cannot change your passowrd, as you are using a social plugin eg:facebook,google',"status"=>false,"errors"=>"You cannot change your passowrd, as you are using a social plugin eg:facebook,google."],403));
    }
 

  public function canTheUserUpdateEmail(User $user)
    {
      
        return !empty($user->email_verified_at)
         ? abort(response()->json(["message"=>'Cannot change an already verified email.',"status"=>false,"errors"=>"Cannot change an already verified email."],403)):Response::allow()
                ;
    }

}
