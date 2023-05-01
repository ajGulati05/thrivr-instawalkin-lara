<?php

namespace App\Http\Controllers\Usersapi\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserNotifications;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UsersApi\v2\UsernotificationResource;
class UserNotificationsController extends Controller
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
        
        $user=Auth::user();
         return response()->json(['status'=>true,'data'=>new UsernotificationResource ($user->usernotifications),'code'=>'200'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
 
       $user=Auth::user();

      $validator = Validator::make($request->all(), [
            'text_reminder' =>'required|integer|max:1|min:0',
            'email_reminder' => 'required|integer|max:1|min:0',
            'email_receipt' => 'required|integer|max:1|min:0',
            'email_confirmation' => 'required|integer|max:1|min:0',
            'product_update' => 'required|integer|max:1|min:0'
            
        ]);
 

 if ($validator->fails()) {
                   return response()->json(['errors'=>$validator->errors(),'status'=>false]);
        }

         
        $user->usernotifications()->update([

            'email_confirmation'=>request('email_confirmation'),
           
            'email_receipt'=>request('email_receipt'),
            'email_reminder'=>request('email_reminder'),
           
            'text_reminder'=> request('text_reminder'),
            'product_update'=> request('product_update')

            ]);
           
       
        return response()->json(['status'=>true,'data'=>new UsernotificationResource ($user->usernotifications)],200);
    }


 

  
}
