<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timings extends Model
{
     
 protected $fillable = ['location_id', 'day_id','open', 'close'];

     public function locations()
	{
		return $this->belongsTo(Location::class);
	}

	   public function days()
	{
		return $this->belongsTo(Days::class,'day_id','id');
	}
}
