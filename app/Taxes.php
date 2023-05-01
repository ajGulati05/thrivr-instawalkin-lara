<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
class Taxes extends Model
{

    protected $casts=[
        'end_date'=>'datetime'
    ];
    //
	protected $guarded=[];
     public function services(){
            return $this->belongsToMany(Service::class);
    }

    public function project_pricings(){
        return $this->belongsToMany(ProjectPricing::class,'projectpricings_taxes','tax_id');
    }
    
    public function scopeActivetaxes($query){
          $query->whereNull('end_date');
    }

   
}
