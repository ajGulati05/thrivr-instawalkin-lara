<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{
    //

    protected $guarded=[];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
   

    public function location(){
            return $this->belongsTo(Location::class);
    }

  

    public function gender(){
            return $this->belongsTo(Gender::class, 'gender_id','code');
    }

      public function services(){
            return $this->belongsToMany(Service::class);
    }
}
