<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Servicecategory;
class Locationtype extends Model
{
    //
 protected $guarded=[];
 protected $hidden = [
        'created_at', 'updated_at',
    ];
 
      use SoftDeletes;
      protected $dates = ['deleted_at'];

     public function locations(){
            return $this->belongsToMany(Location::class);
    }

    public function servicecategories()
    {
    	return $this->belongsToMany(Servicecategory::class, 'locationtypes_servicecategories', 'ltype_id','scategories_id');
    }


     public function servicecategoriesdropdown()
    {
      return $this->belongsToMany(Servicecategory::class, 'locationtypes_servicecategories', 'ltype_id','scategories_id')->select(array('id', 'description'));
    }
}

