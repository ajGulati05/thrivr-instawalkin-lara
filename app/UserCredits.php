<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usercredits extends Model
{
    //
     protected $guarded=[];
     protected $table='usercredits';

     public function user(){
            return $this->belongsTo(User::class,"user_id","id");
    }

    public function scopeGreaterthanzero(){
    	return $this->where('amount','>',0);
    }
}
