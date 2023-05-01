<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
	use  Notifiable;
    //
    protected $guarded=[];
     public function routeNotificationForSlack($notification)
    {
        return config('slack.contact');
    }
}
