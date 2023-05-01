<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmodalitiesPricing extends Model

{

    

    public function submodalitiy(){

      return $this->belongsTo('App\SubModalitie', 'sub_modalities_code','code');

    }

    public function scopeActivePricing($query){

      return $query->whereNull('expired_at');

    }

}