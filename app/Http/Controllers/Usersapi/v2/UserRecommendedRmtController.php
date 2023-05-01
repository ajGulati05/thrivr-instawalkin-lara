<?php

namespace App\Http\Controllers\Usersapi\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\UserRecommendedRmt;
use App\Notifications\RecommendedRmtNotification;
use Notification;
class UserRecommendedRmtController extends Controller
{
    

    public function storeWithAuth(Request $request)
    {
        $user= Auth::user()->id;
       return $this->store($request,$user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id=null)
    {
      $validatedData = Validator::make($request->all(),[
      'therapist_name' => 'required|min:5',
      'therapist_email'=>'sometimes|email',
      'therapist_business'=>'sometimes|string'
    ]);


 if ($validatedData->fails()) {
                   return response()->json(["message"=> "The given data was invalid.",'errors'=>$validatedData->errors(),'status'=>false],422);
        }
          $userRecommended = UserRecommendedRmt::Create([

               'therapist_name' => request('therapist_name'),
               'therapist_email'=>request('therapist_email'),
               'therapist_business'=>request('therapist_business'),
               'user_id' =>$id,
               'connected' => false

          ]);
          $userRecommended->notify(new RecommendedRmtNotification($userRecommended));
          return response()->json(["message"=>"Thank you for your recommendation, we wil be reaching out to the RMT in the next 24 hours","status"=>true],200);
        
     }


}
