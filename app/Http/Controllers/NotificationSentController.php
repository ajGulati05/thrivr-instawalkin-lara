<?php

namespace App\Http\Controllers;

use App\NotificationSent;
use Illuminate\Http\Request;
use JWTAuth;
 use App\Http\Resources\NotificationSentResource;
 use Illuminate\Support\Facades\Log;
class NotificationSentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NotificationSent  $notificationSent
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationSent $notificationSent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NotificationSent  $notificationSent
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationSent $notificationSent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NotificationSent  $notificationSent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationSent $notificationSent)
    {
      
      $token = JWTAuth::getToken();
      $user = JWTAuth::toUser($token);

    

         
       $notificationsent= NotificationSent::where('id', request('id'))->Update([

            'read'=>true
           
            
            ]);
           
       
      //  return response()->json(['error'=>'false','usersprofile'=>$usersprofile,'code'=>'200'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationSent  $notificationSent
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationSent $notificationSent)
    {
        //
    }

     public function getRecentUnreadNotifications(){
    $token = JWTAuth::getToken();
    
    $user = JWTAuth::toUser($token);


      //get top history thats unread..
      //change it to read
      //and send it back 

  $notificationsent= NotificationSent::where('user_id',$user->id)->where('read',0)->take(1)->orderBy('id','desc')->first();

  if(!$notificationsent){
    return response()->json(['error'=>'false','code'=>'200'],200);
  }
  return new  NotificationSentResource($notificationsent);  

  
    }
}
