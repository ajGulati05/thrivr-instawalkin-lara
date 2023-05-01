<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
class RewardEmail extends Model
{
   use  Notifiable,SnoozeNotifiable;
   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = ['email','name'
      
    ];


    public function user(){
            return $this->belongsTo(User::class);
    }


  protected $casts = [
    'accepted' => 'boolean'
  ];

    public function setAcceptedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['accepted'] = 1;
    } else {
      $this->attributes['accepted'] = 0;
    }
  }

}
