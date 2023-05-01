<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class DemoRequest extends Model
{
	 use  Notifiable;
    protected $fillable=['email','timekit_resource_id','phone','name','demo_date'];


  public function routeNotificationForSlack($notification)
    {
        return config('slack.demo');
    }
}


