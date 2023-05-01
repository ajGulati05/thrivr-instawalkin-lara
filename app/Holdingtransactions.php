<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Holdingtransactions extends Model
{
    //

    protected $guarded=[];
 protected $casts = [
        'approved' => 'boolean',
        'read'=>'boolean'
    ];
    public function users(){
            return $this->belongsTo(User::class,'user_id','id');
    }

     public function instaprices(){
            return $this->belongsTo(Instaprice::class,'price_id','id');
    }

    
     public function servicecategories(){
            return $this->belongsTo(Servicecategory::class,'servicecategories_id','id');
    }

 

      public function getApprovedAttribute($value)
    {
        
          if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
       
    }


        public function setApprovedAttribute($value)
    {
        
             
               if($value==true){
      $this->attributes['approved'] = 1;
    }
    else{
      $this->attributes['approved'] = 0;
    }
       
    }

       public function modifyservicedate($value)
    {
       return Carbon::parse( $value);
    }
    public function modifyservicestarttime($value)
    {
    	return Carbon::parse( $value)->timezone('America/Regina')->format('H:i:s');
    }

     public function modifyserviceEndtime($value)
    {
    	return Carbon::parse( $value)->timezone('America/Regina')->format('H:i:s');
    }


   

          public function getReadAttribute($value)
    {
        
          if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
       
    }


        public function setReadAttribute($value)
    {
        
             
               if($value==true){
      $this->attributes['read'] = 1;
    }
    else{
      $this->attributes['read'] = 0;
    }
  }
    /**
     * Get all objects that are provisioned
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }
}
