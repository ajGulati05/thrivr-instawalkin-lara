<?php

namespace App;


use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientTherapist extends Pivot
{
    //

      protected $casts = [
    	'blocked' => 'boolean'
  ];


    public function setBlockedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['blocked'] = 1;
    } else {
      $this->attributes['blocked'] = 0;
    }
  }

   public function getBlockedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['blocked'] = 1;
    } else {
      $this->attributes['blocked'] = 0;
    }
  }

  
}
