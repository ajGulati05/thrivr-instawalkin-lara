<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaunchedCities extends Model
{
    protected $guarded=[];
     protected $casts = [
        'status' => 'boolean'

    ];

    /**
 * Get the route key for the model.
 *
 * @return string
 */
public function getRouteKeyName()
{
    return 'city_name';
}
     public function setStatusAttribute($value)
  {
    if ($value == true) {
      $this->attributes['status'] = 1;
    } else {
      $this->attributes['status'] = 0;
    }
  }



       public function rmtTeam()
  {
   return $this->hasMany(RmtTeam::class);
  }
}
