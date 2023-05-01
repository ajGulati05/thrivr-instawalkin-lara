<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BookingTransaction;
class BookingPricing extends Model
{
    protected $fillable = [
        'booking_id','amount','tax_amount','tip_amount','credit_card_amount',
        "discount_amount",'cash_amount','direct_billing_amount','active',"amount_1","amount_2"
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

  public function booking(){
    return $this->belongsTo(Booking::class, 'booking_id','id');
  }
  public function scopeActiveBookingPricing($query)
    {               
            $query->where('active',true);
       
    }

   public function booking_transactions()
    {
        return $this->hasMany(BookingTransaction::class);
    }
    public function active_booking_transactions()
    {
        return $this->booking_transactions()->activeBookingTransactions();
    }

public function topActiveBookingTransaction()
    {
        return $this->booking_transactions()->topActiveBookingTransactions();
    }
    

    public function firstActiveBookingTransaction()
    {
        return $this->active_booking_transactions()->first();
    }
}
