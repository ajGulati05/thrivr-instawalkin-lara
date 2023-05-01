<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AppliedRmt extends Model
{
	use SoftDeletes;

	protected $guarded=['id','approved','reason','deleted_at'];
    
    protected $dates = ['deleted_at'];
     protected $casts = [
    'approved' => 'boolean',
    'self'=>'boolean'
  ];

  public function setSelfAttribute($value)
  {
    if ($value == true) {
      $this->attributes['self'] = 1;
    } else {
      $this->attributes['self'] = 0;
    }
  }
   public function setApprovedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['approved'] = 1;
    } else {
      $this->attributes['approved'] = 0;
    }
  }
}
