<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instaprice extends Model
{
    //
protected $guarded=[];


 public function servicecategories()
    {
    	return $this->belongsTo(Servicecategory::class, 'servicecategories_id')->orderBy('ordernumber');
    }



          public function scopeInstapricescurrentdates($query)
    {
        return $query->whereNull('start_date')->whereNull('end_date');
    }
}
