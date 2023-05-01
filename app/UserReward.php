<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
  public const REWARDEE_REWARD='10';
  public const INVITEE_REWARD='10';
    protected $fillable = ['debit','credit'];

       public function user(){
            return $this->belongsTo(User::class);
    }
}
