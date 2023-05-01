<?php

namespace App\Http\Controllers\Usersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserNotifications;
use Illuminate\Support\Facades\Validator;

class UserNotificationsController extends Controller
{
  

protected function validator(array $data)
    {
          
          
       $validator=Validator::make($data, [
            'allnotifications'=>'required',
            'viapush'=>'required',
            'viatext'=>'required'
            ]);
          
     return $validator; 
    }

      /**
     * Display the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function getNotificationSettings()
    {
        //
        
        $user=Auth::user();
         return response()->json(['error'=>'false','notification_settings'=>$user->usernotifications,'code'=>'200'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
      

       $user=Auth::user();
       
        return response()->json(['error'=>'true','notifications'=>$notifications,'code'=>'200'],200);
    }


 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function postNotificationSettings(Request $request)
    {
        //

        

         $user=Auth::user();
    

          return response()->json(['error'=>'false','success'=>false,'code'=>'200'],200);
      
      }

    }

  

