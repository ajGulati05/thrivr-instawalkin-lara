<?php

namespace App\Http\Controllers\Managersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\TherapistResource; 
use App\Manager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\UploadImageClass;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Storage;
class TherapistProfileController extends Controller
{
     

    public function getTherapistProfile(){
        $therapist=Auth::user();
    	$threapistProfile=$therapist->load('profiles');
       
    	return response()->json(['data'=>new TherapistResource($threapistProfile),'status'=>true],200);
    } 

    
   public function uploadImage(Request $request)
    {

          $mini_avatar_attributes = 
    array('width'=>Manager::SMALL_AVATAR_WIDTH, 'height'=>Manager::SMALL_AVATAR_HEIGHT);
        $avatar_attributes = 
    array('width'=>Manager::BIG_AVATAR_WIDTH, 'height'=>Manager::BIG_AVATAR_HEIGHT);
            $therapist = Auth::user();
            $filePath=UploadImageClass::uploadImage($request, $therapist->first_name,$therapist->last_name,$therapist->profile_photo,'managers/',Manager::BIG_AVATAR_WIDTH,Manager::BIG_AVATAR_HEIGHT);
            $miniFilePath=UploadImageClass::uploadImage($request, $therapist->first_name,$therapist->last_name,$therapist->profile_photo,'managers/',Manager::SMALL_AVATAR_WIDTH,Manager::SMALL_AVATAR_HEIGHT,'mini');
            $therapist->Update(['profile_photo'=>$filePath,
              'mini_avatar'=>$miniFilePath,
              'mini_avatar_attributes'=>$mini_avatar_attributes,
               'avatar_attributes'=>$avatar_attributes
            ]);
            return response()->json(['status'=>true,'message'=>'Image uploaded successfully','data'=>['avatar'=>
            config('app.s3_bucket_address').$therapist->profile_photo]],200);
        

    }

       public function tutorialComplete(Request $request){

          $therapist = Auth::user();
          $therapist->skip=true;
          $therapist->save();
        $threapistProfile=$therapist->load('profiles');
       
      return response()->json(['data'=>new TherapistResource($threapistProfile),'status'=>true],200);

       }
   public function updateTherapist(Request $request){
        $therapist=Auth::user();
          
          $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'business_name' => 'required|string',
            'gender' => ['required',Rule::in(['M','F','O'])]
            
            
        ]);

          $therapist->update([
          	'first_name'=>request('firstname'),
          	'last_name'=>request('lastname'),
          	'business_name'=>request('business_name'),
          	'gender'=>request('gender')

          ]);
    	$threapistProfile=$therapist->load('profiles');
       
    	return response()->json(['data'=>new TherapistResource($threapistProfile),'status'=>true],200);
    } 
    public function firstLogin(){
         $therapist=Auth::user();
         $therapist->first_login=true;
         $therapist->save();
          $threapistProfile=$therapist->load('profiles');
        return response()->json(['data'=>new TherapistResource($threapistProfile),'status'=>true],200);
    }

     public function storeTherapistProfile(Request $request){
        $therapist=Auth::user();

        Log::debug($request);
            $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|min:17|max:17',
            'city' => 'required|string',
            'province' =>'required|string|size:2',
            'postal_code'=>'required|string|size:6',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'tag_line'=>'required|string|min:10|max:100',
            'parking'=>['required',Rule::in([1,0])],
            'address_description'=>'sometimes|string|min:5|max:400|nullable',
            'parking_description'=>'sometimes|string|min:5|max:400|nullable',
            'about'=>'required|string|min:20|max:600',
            'direct_billing'=>['required',Rule::in([1,0])],

        ]);
 $toRemove = array(" ", "(", ")", "-");
        $toReplaceWith   = array("", "", "", "");

             $therapist->profiles()->create([
             'address' => request('address'),
            'phone' =>  str_replace($toRemove, $toReplaceWith, request('phone')),
            'city' => request('city'),
            'province' =>request('province'),
            'postal_code'=>request('postal_code'),
            'latitude'=>request('latitude'),
            'longitude'=>request('longitude'),
            'tag_line'=>request('tag_line'),
            'parking'=>request('parking'),
            'address_description'=>request('address_description'),
            'parking_description'=>request('parking_description'),
            'about'=>request('about'),
            'direct_billing'=>request('direct_billing')
       

          ]);
$threapistProfile=$therapist->load('profiles');


       
      return response()->json(['data'=>new TherapistResource($threapistProfile),'status'=>true],200);
    }

    public function updateTherapistProfile(Request $request){
        $therapist=Auth::user();
            $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|min:17|max:17',
            'city' => 'required|string',
            'province' =>'required|string|size:2',
            'postal_code'=>'required|string|size:6',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'tag_line'=>'required|string|min:10|max:100',
            'parking'=>['required',Rule::in([1,0])],
                'address_description'=>'sometimes|string|min:5|max:400|nullable',
            'parking_description'=>'sometimes|string|min:5|max:400|nullable',
            'about'=>'required|string|min:20|max:600',
            'direct_billing'=>['required',Rule::in([1,0])],
            
        ]);
 $toRemove = array(" ", "(", ")", "-");
        $toReplaceWith   = array("", "", "", "");
$position=new Point(request('latitude'), request('longitude'),4326);
     
             $therapist->profiles()->update([
             'address' => request('address'),
            'phone' =>  str_replace($toRemove, $toReplaceWith, request('phone')),
            'city' => request('city'),
            'province' =>request('province'),
            'postal_code'=>request('postal_code'),
            'latitude'=>request('latitude'),
            'longitude'=>request('longitude'),
            'tag_line'=>request('tag_line'),
            'parking'=>request('parking'),
            'address_description'=>request('address_description'),
            'parking_description'=>request('parking_description'),
            'about'=>request('about'),
            'direct_billing'=>request('direct_billing'),
          'position'=>$position
       

          ]);

    	$threapistProfile=$therapist->load('profiles');


       
    	return response()->json(['data'=>new TherapistResource($threapistProfile),'status'=>true],200);
    } 
}
