<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Corporationpromo;
class CorporationpromoUser extends Model
{
    //
	protected $guarded=[];

	 protected $casts = [
        'validated' => 'boolean',
    ];
     public function user(){
            return $this->belongsTo(User::class,"users_id","id");
    }

    public function corporationpromos(){
    		 return $this->belongsTo(Corporationpromo::class,"corporationpromos_id","id");
    }
  
  public function getValidatedAttribute($value)
    {
        
          if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
       
    }


        public function setValidatedAttribute($value)
    {
        
             
               if($value==true){
      $this->attributes['validated'] = 1;
    }
    else{
      $this->attributes['validated'] = 0;
    }
}


	  public function scopeValidated($query)
    {
        return $query->where('users_id', '=' ,true);
    }

}
