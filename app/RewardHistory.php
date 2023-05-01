<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardHistory extends Model
{


    protected $fillable = ['reward', 'rewardee_id','pending','read','user_id'];


    public function rewardee()
    {
        return $this->belongsTo(User::class, 'rewardee_id', 'id');
    }


    public function invitee()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
        'read' => 'boolean',
        'pending'=>'boolean'
    ];


    public function setPendingAttribute($value)
    {
        if ($value == true) {
            $this->attributes['pending'] = 1;
        } else {
            $this->attributes['pending'] = 0;
        }
    }


    public function scopePending($query)
    {
        return $query->where('pending', false);
    }
    public function setReadAttribute($value)
    {
        if ($value == true) {
            $this->attributes['read'] = 1;
        } else {
            $this->attributes['read'] = 0;
        }
    }


    public function scopeNotRead($query)
    {
        return $query->where('read', false);
    }
}
