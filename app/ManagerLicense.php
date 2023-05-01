<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ManagerLicense extends Model
{

    protected $casts = [
        'expired_at' => 'datetime',
        'validated_at' => 'datetime'
    ];

    protected $fillable = [
        'expired_at', 'validated', 'manager_id', 'license_number'
    ];

    public function managers()
    {
        return $this->belongsTo('App\Manager', 'manager_id');
    }

    public function scopeActiveManagerLicense($query)
    {
        $todayTime = Carbon::now('UTC');
        return $query->whereDate('expired_at', '>', $todayTime);
    }
}
