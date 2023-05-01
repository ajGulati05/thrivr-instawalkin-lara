<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    //
    public const SMALL_AVATAR_WIDTH=48;
   public const SMALL_AVATAR_HEIGHT=48;

    protected $guarded=[];
  	  protected $hidden = [
        'id', 'user_id','created_at','updated_at'
    ];

    public function user(){
            return $this->belongsTo(User::class);
    }

  
}
