<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
class SecondaryEmails extends Model
{
	
   use Notifiable;
   protected $guarded=[];

  public function managers()
    {
        return $this->belongsToMany('App\Manager','manager_secondary_email','manager_id');
    }
}
