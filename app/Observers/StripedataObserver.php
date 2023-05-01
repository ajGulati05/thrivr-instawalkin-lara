<?php

namespace App\Observers;
use Illuminate\Http\Request;
use App\Stripedata;

class StripedataObserver
{
     public function __construct(Request $request)
        {
            $this->request = $request;
        }
    public function created(Stripedata $stripedata)
    	{
        //
       //  UserNotifications::Create([
         //   'user_id' => $user->id
        //]);
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
}
