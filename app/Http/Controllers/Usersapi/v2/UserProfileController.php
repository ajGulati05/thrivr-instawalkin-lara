<?php

namespace App\Http\Controllers\Usersapi\v2;

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
use Storage;
use App\Helpers\UploadImageClass;
class UserProfileController extends Controller
{
     

    public function getUserProfile(){
    	$userprofile=User::with('userprofiles')->where('id',Auth::user()->id)->get();
    	return response()->json(['data'=>UserProfiles::collection($userprofile)[0],'status'=>true],200);
    } 

    
   public function uploadImage(Request $request)
    {

          $userprofile = Auth::user()->userprofiles;
                  $filePath=UploadImageClass::uploadImage($request, $userprofile->firstname,$userprofile->lastname,$userprofile->avatar,'avatar/',Userprofile::SMALL_AVATAR_WIDTH,Userprofile::SMALL_AVATAR_HEIGHT);
        $avatar_attributes = 
    array('width'=>Userprofile::SMALL_AVATAR_WIDTH, 'height'=>Userprofile::SMALL_AVATAR_HEIGHT);
         
        $userprofile->Update(['avatar'=>$filePath,'avatar_attributes'=>$avatar_attributes]);


         
           return response()->json(['status'=>true,'message'=>'Image uploaded successfully','data'=>['avatar'=>
            config('app.s3_bucket_address').$userprofile->avatar]],200);
        
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

$user = Auth::user();
 $request->validate([
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
       
    return response()->json(["message"=>"Your user profile has been updated.","status"=>true],200);

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


    public function emaiUpdate(Request $request){
         $user=Auth::user();
        if($this->authorize('canTheUserUpdateEmail',$user)){
           $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            ]);

       
        $user->update(['email'=>request('email')]);
        $userprofile=$user->load('userprofiles');
        $user->sendEmailVerificationNotification();
        return response()->json(['data'=>new UserProfiles($userprofile),'status'=>true],200);
    }
    }
}
