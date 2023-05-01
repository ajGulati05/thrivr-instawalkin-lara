<?php

namespace App\Http\Controllers\Managersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Manager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\TherapistNotificationsResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class ManagersNotificationController extends Controller
{

  

      /**
     * Display the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        //
        
        $manager=Auth::user();
         return response()->json(['status'=>true,'data'=>new TherapistNotificationsResource($manager->managernotifications)],200);
    }


  /**
     * Display the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
          $manager=Auth::user();

        $request->validate([
            'booking_texts' =>['required',Rule::in([1,0])],
            'booking_emails' => ['required',Rule::in([1,0])],
            'review_emails' =>  ['required',Rule::in([1,0])]
     ]);
 


         
        $manager->managernotifications()->update([

            'booking_texts'=>request('booking_texts'),
           
            'booking_emails'=>request('booking_emails'),
            'review_emails'=>request('review_emails'),


            ]);
           
       
       
         return response()->json(['status'=>true,'data'=>new TherapistNotificationsResource($manager->managernotifications)],200);
    }
}
