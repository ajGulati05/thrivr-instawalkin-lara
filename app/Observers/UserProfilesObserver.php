<?php

namespace App\Observers;

use App\Userprofile;
use App\User;
class UserProfilesObserver
{
    /**
     * Handle the userprofiles "created" event.
     *
     * @param  \App\Userprofile $userprofiles
     * @return void
     */
    public function created(Userprofile $userprofiles)
    {
            $user=$userprofiles->user;
            User::generateReferral($user);
    }

}
