<?php

namespace App\Http\Controllers\Usersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Userprofile;
use App\User;
use App\Http\Resources\UsersApiNew\UserProfiles; 
use Illuminate\Support\Facades\Validator;
use App\Stripedata;
use App\Http\Resources\UsersApiNew\StripeDataResources;
class UserProfileController extends Controller
{
     

    public function getUserProfile(){
    	$userprofile=User::with('userprofiles')->where('id',Auth::user()->id)->get();
    	return UserProfiles::collection($userprofile)[0];
    } 

   public function checkAuth(){
       
             if (Auth::guard('usersapi')->check() == 1) {
                 return response()->json(['check'=>true]);
         }
             else {
                 return response()->json(['check'=>false]);
             }
         }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Userprofile $userprofile)
    {
        //

  
         $user = Auth::user();

$validatedData = $request->validate([
        'firstname'=>'required|string',
        'lastname'=>'required|string',
        'phone'=>'required|string|min:11|max:17',
    ]);

           $toRemove = array(" ", "(", ")", "-");
        $toReplaceWith   = array("", "", "","");
        $phone = $newphrase = str_replace($toRemove, $toReplaceWith, request('phone'));
       $userprofile= Userprofile::where('user_id', $user->id)->Update([

            'firstname'=>request('firstname'),
            'lastname'=>request('lastname'),
            'phone'=>$phone,

            
            ]);
       
       if($userprofile=='1'){
             return response()->json(['error'=>false,'message'=>'success','code'=>200],200);
       }
    	else{
                 return response()->json(['error'=>true,'code'=>400],400);
        }

    }


          /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function getPaymentOptions()
    {
        //

       $paymentoptions =StripeData::where('user_id',Auth::user()->id)->get();
       return StripeDataResources::collection($paymentoptions)->keyBy('id');
         

    }
}
