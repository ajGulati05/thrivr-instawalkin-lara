<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubModalitie extends Model

{

public $table='sub_modalities';

protected $primaryKey = 'code'; // or null

public $incrementing = false;

protected $keyType = 'string';

protected $casts = [

    'active' => 'boolean'

  ];

  public function setActiveAttribute($value)

  {

    if ($value == true) {

      $this->attributes['active'] = 1;

    } else {

      $this->attributes['active'] = 0;

    }

  }

   /**

     * The roles that belong to the user.

     */

    public function managers()

    {

        return $this->belongsToMany('App\Manager', 'manager_submodalities',  'sub_modalities_code','manager_id');

    }

    public function scopeActive(){
      return $this->whereNull('expired_date');
    }

    public function subModalitiesPricings(){

            return $this->hasMany('App\SubmodalitiesPricing','sub_modalities_code','code');

      }

      public function firstActiveSubModaltiesPricing(){

            return $this->subModalitiesPricings()->active();

      }

}