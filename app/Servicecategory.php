<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Servicecategory extends Model
{
    //
    
    protected $guarded=['created_at'];
  
      use SoftDeletes;
      protected $dates = ['deleted_at'];

    public function service()
    {
    	return $this->hasOne(Service::class);
    }
  public function services()
    {
        return $this->hasMany(Service::class,'servicecategory_id', 'id');
    }
    public function locationtypes()
    {
    	return $this->belongsToMany(Locationtype::class, 'locationtypes_servicecategories','scategories_id', 'ltype_id');
    }

        public function instaprices()
    {
        return $this->hasMany(Instaprice::class, 'servicecategories_id', 'id')->instapricescurrentdates();
    }


   
         public function scopeInstapricesquery($query)
    {
        return $query->has('instaprices')->get();
    }

    
}
