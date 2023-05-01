<?php

namespace App\Observers;
use App\Guest;

class GuestObserver
{
  



  public function created(ManagerLicense $managerlicense)
    {
      $today=Carbon::now();
      $toBeDisabledLicense=ManagerLicense::where('id','!=',$managerlicense->id)->whereNull('expired_at')->where('manager_id',$managerlicense->manager_id)
      ->update(['expired_at'=>$today]);
      $managerlicense->update(['validated_at'=>$today]);
    }


}
