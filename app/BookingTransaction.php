<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingTransaction extends Model
{
    protected $fillable = [
        'booking_pricing_id', 'charge_id',"capture_charge_id",
        "stripe_code_status_charge","stripe_reason_charge","stripe_code_status_authorize",
        "stripe_reason_authorize","stripedatas_id",'active'
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

 public function bookingPricing(){
    return $this->belongsTo(BookingPricing::class, 'booking_pricing_id','id');
  }
       public function scopeActiveBookingTransactions($query)
    {               
            $query->where('active',true);
       
    }

    public function stripedatas()
    {
        return $this->belongsTo(Stripedata::class,'stripedatas_id','id')->withDefault(['card_brand'=>null,'card_last_four'=>null
        ]);
    }
 public function stripedatasWithTrashed()
    {
        return $this->stripedatas()->withTrashed();
    }

     public function scopeTopActiveBookingTransactions($query)
    {               
            $query->where('active',true)->first();
       
    }
}
