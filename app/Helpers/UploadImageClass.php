<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Storage;
use Image;
class UploadImageClass 
{
     


    
   public static function uploadImage(Request $request, $userfirstname,$userlastname,$oldImage,$folderPath,$width,$height,$appendString=null)
    {

//Pass the validation
           $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:50000'
    ]);


           $fileToIntervene=$request->file('avatar');

           return (new self)->storeImages($fileToIntervene, $userfirstname,$userlastname,$oldImage,$folderPath,$width,$height,$appendString=null);
            

        
    }


public static function storeImages($fileToIntervene,$userfirstname,$userlastname,$oldImage,$folderPath,$width,$height,$appendString=null){


            $file = (new self)->imageResize($fileToIntervene,$width,$height);
            $name=time().$userfirstname."_".$userlastname.".".$fileToIntervene->extension();

            $filePath = $folderPath . $name;
                if(isset($appendString)){
              $filePath = $folderPath . $appendString.'_'.$name;
            }
           Storage::disk('s3')->put($filePath, (string) $file, 'public');
           Storage::disk('s3')->delete($oldImage);
             return $filePath;
}


    // usage inside a laravel route
    public  function imageResize($image,$width,$height)
    {
        $img = Image::make($image)->resize($width, $height);
        return $img->encode('jpg');
  }

}
     //file_get_contents($file)