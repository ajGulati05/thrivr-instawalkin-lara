<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stripedata extends Model
{
  //
  use SoftDeletes;

  protected $guarded = [];
  protected $dates = ['deleted_at'];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $visible = ['id', 'stripe_id', 'card_brand', 'card_last_four', 'card_token', 'default_card', 'native_pay'];


  protected $casts = [
    'native_pay' => 'boolean',
    'default_card'=>'boolean'


  ];
 public function getDefaultCardAttribute($value)
  {


    if ($value == 1) {
      return  true;
    } else {
      return  false;
    }
  }

  public function setDefaultCardAttribute($value)
  {
    if ($value == true) {
      $this->attributes['default_card'] = 1;
    } else {
      $this->attributes['default_card'] = 0;
    }
  }
  public function getNativePayAttribute($value)
  {


    if ($value == 1) {
      return  true;
    } else {
      return  false;
    }
  }

  public function setNativePayAttribute($value)
  {
    if ($value == true) {
      $this->attributes['native_pay'] = 1;
    } else {
      $this->attributes['native_pay'] = 0;
    }
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function scopecardsNotNativePay($query){
    return $query->where('native_pay',0);
  }
}
