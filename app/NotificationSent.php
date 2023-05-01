<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSent extends Model
{
    //
 protected $table="notifications_sent";   
 protected $guarded=[];
 protected $casts = [
        
        'read'=>'boolean',
        'notfication_data' => 'array',
    ];

     public function users(){
            return $this->belongsTo(User::class,'user_id','id');
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
    }}

      /**
     * Get all objects that are provisioned
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
}
