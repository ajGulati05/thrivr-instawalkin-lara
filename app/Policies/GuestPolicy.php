<?php

namespace App\Policies;

use App\Guest;
use App\Manager;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
class GuestPolicy
{
    use HandlesAuthorization;

 
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Guest  $guest
     * @return mixed
     */
    public function update(Manager $manager, Guest $guest)
    {
         return $manager->id===$guest->manager_id
         ? Response::allow()
                :abort(response()->json(["message"=>'Forbidden.',"status"=>false,"errors"=>"Forbidden."],403));
    }

}
