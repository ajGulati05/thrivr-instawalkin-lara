<?php

namespace App\Http\Controllers\Usersapi\v2\PromoCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Extensions\CustomPromocode;
use Promocodes;
use App\Helpers\PromoCodeClass;
class PromoCodeController extends Controller
{
   
    public function canUsePromoCode($code){
              $promoCodeHelper=new PromoCodeClass();
        
          return $promoCodeHelper->canPromoCodeBeUsed($code);
    }




}


//Promocodes::check($code);

//Promocodes::isSecondUsageAttempt`