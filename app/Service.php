<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Servicecategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class Service extends Model
{
    //
	protected $guarded=[];
     use SoftDeletes;
      protected $dates = ['deleted_at'];
    public static function active()
    {
    	return static::where('status',0)->get();
    }

    public function location(){
            return $this->belongsTo(Location::class);
    }
     public function servicecategory(){
            return $this->belongsTo(Servicecategory::class, 'servicecategory_id','id');
    }

    public function scopeStatus($query)
	{
    return $query->where('status', '=', false);
	}

    public function getServiceName()
    {
        
        return $this->servicecategory();
    }


    public function taxes(){
            return $this->belongsToMany(Taxes::class);
    }

 
    public function Employees(){
            return $this->belongsToMany(Employees::class);
    }
   
    public function transactions(){
        return $this->hasMany(Transactions::class,'service_id','id');
    }

          public function scopeServiceslocationsquery($query,$filter)
    {
        return $query->where('location_id',$filter)->get();
    }
}
