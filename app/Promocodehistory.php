<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocodehistory extends Model
{
    //

    protected $table = 'promocodehistorys';
 protected $guarded=[];
 public $timestamps = false;

          public function scopePromocodeusedcount($query,$filters)
    {
       
      
           return $query->where('promocode_id', '=',$filters['promocode_id']);
       
    }


          public function scopePromocodeusercount($query,$filters)
    {
       
      
           return $query->where('user_id', '=',$filters['user_id']);
       
    }
}
