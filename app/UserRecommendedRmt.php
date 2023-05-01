<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class UserRecommendedRmt extends Model
{
           use  Notifiable;
        protected $guarded=[];
        protected $table='user_recommended_rmt';
             public function user(){
          return $this->hasOne('App\User');
        }


          public function routeNotificationForSlack($notification)
    {
        return config('slack.recommended');
    }
}
