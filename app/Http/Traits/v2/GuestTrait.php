<?php

namespace App\Http\Traits\v2;

use Illuminate\Support\Facades\Log;
use App\User;
use App\Guest;
trait GuestTrait
{

    /**
     * Does the guest already exist in the Users table
     *
     * @return bool
     */

    public function doesEmailExistsInUsers(Guest $guest){
        return User::where('email',$guest->email)->exists();
    }


    public function getUserForEmail(Guest $guest){


      return User::where('email',$guest->email)->firstOrFail();
    }

}
