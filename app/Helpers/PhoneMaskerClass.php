<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PhoneMaskerClass 
{
     


    
   public static function removeMask($phone)
    {


    
        if(isset($phone)){
        $toRemove = array(" ", "(", ")", "-");
        $toReplaceWith   = array("", "", "","");

           
        $phone = str_replace($toRemove, $toReplaceWith, request('phone'));
        }
        
        return $phone;

    }

}
   