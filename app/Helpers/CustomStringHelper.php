<?php
namespace App\Helpers;
use Exception;
use Illuminate\Support\Facades\Log;
class CustomStringHelper
{

  public static function getFirstIntegerFromString($arg){

      try{
            preg_match_all('/([\d]+)/', $arg, $arrayHolder);
            return $arrayHolder[0][0];
         }
       catch (Exception $ex) {
          Log::critical("Issue with getting integer froms string". $arg .$ex);

        }

        return $arg;
     
}


public static function addBufferPlusMinutesString($arg1,$arg2){

  return $arg1+$arg2 . ' minutes';

}
}