<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;




use Illuminate\Support\Facades\Auth;

use App\Http\Resources\UsersApi\v2\PromoCode;
use App\Http\Extensions\CustomPromocode;
use App\Http\Resources\UsersApi\v2\PromoCode\PromoCodeResource;
use Gabievi\Promocodes\Exceptions\AlreadyUsedException;
class PromoCodeClass 
{
     

  public function runPromoCodeCheck($code){
    

       
        $promoCode= CustomPromocode::check($code);

//TODO fix monthly data promo code
       // if($this->isMonthly($promoCode))
        //{  
          //  $data= $this->monthlyPromoCheck($promoCode);
        //}
        //else {
            $data=$this->normalPromoCheck($promoCode);
        //}
       
        if($data){
           
            throw new AlreadyUsedException;
        }

       
       return $promoCode;

    }
 
    public function isMonthly($code){
        return $code->data['monthly'];
    }

    public function monthlyPromoCheck($code){
         return CustomPromocode::isSecondUsageAttempt($code);
    }


    public function normalPromoCheck($code){
        return CustomPromocode::isSecondUsageAttempt($code);
    }
    public function canPromoCodeBeUsed($code){
    

        $data=$this->runPromoCodeCheck($code);
       
        return response()->json(["status"=>true,"data"=>new PromoCodeResource($data)],200);

    }

    

    public function removeAppliedPromoCode(){
        return false;
    }


}
   