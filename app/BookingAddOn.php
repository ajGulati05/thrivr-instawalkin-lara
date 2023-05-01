<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingAddOn extends Model
{
    //
    protected $fillable = [
      "sub_modalities_code" ,"booking_id",
                                         "tax_amount", 
                                         "amount",
                                         "active"
    ];

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
  public function subModalties(){
    return $this->belongsTo(SubModalitie::class,'sub_modalities_code','code');
  }


  public function scopeActive(){
    return $this->where('active',1);
  }
}



//Booking currently the way it works  is you it closes after