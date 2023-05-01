<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailypromo extends Model
{
    //
    protected $guarded = [];


      public function locationtypes(){
            return $this->hasOne(Locationtype::class,'id','locationtype_id');
    }
}
