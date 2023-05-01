<?php

namespace App\Http\Traits\v2;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


trait ReconcileUserTypeTrait
{


    //A booking can be canceled by the user or rescheduled
    // A booking cancelled or reschduled is only charged if its less than 60 minutes left to the appointment


    public function reconcileUser(Request $request)
    {

     
        if ($request->exists('user') && $request->has('user')) {

                return request('user');
        }

        if ($request->exists('guest') && $request->has('guest')) {
            return request('guest');
        }

            if ($request->exists('userGuest') && $request->has('userGuest')) {
                return request('userGuest');
            }


            abort(403);
        }


}
