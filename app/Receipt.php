<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        "booking_id",
        "request_date",
        "requested_by",
        "requested_by_id",
        "duplicated"
    ];


    

    public function bookings(){
    	return $this->belongsTo('App\Booking','booking_id','id');
    }
}
