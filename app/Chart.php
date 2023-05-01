<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Roelofr\EncryptionCast\Casts\EncryptedAttribute;
use App\Http\Abstracts\UuidModel;
class Chart extends UuidModel
{
    //

     protected $fillable = [
        'user_id', 'manager_id', "userguest_id",
        "data", "locked","chart_types_code","parent_id"
    ];
protected $casts = [
        'locked' => 'boolean',
        'data'=>EncryptedAttribute::class.':collection',
    ];


  public function setLockedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['locked'] = 1;
    } else {
      $this->attributes['locked'] = 0;
    }
  }
       /**
     * Get the owning imageable model.
     */
    public function chartable()
    {
        return $this->morphTo();
    }
     public function scopeLocked($query){
            return $query->where('locked',1);
    }

      public function managers(){
        return $this->hasOne('App\Manager');
    }

     public function userGuests(){
      return $this->hasOne(UserGuest::class,'id','userguest_id');
    }

      public function chartType()
    {
        return $this->belongsTo("App\ChartType","chart_types_code","code");
    }

      public function scopeUserType($query)
    {
        return $query->where('chartable_type', 'App\User');
    }

   
       public function scopeGuestType($query)
    {
        return $query->where('chartable_type', 'App\Guest');
    }


      public function parent()
    {
        return $this->belongsTo('App\Chart', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Chart', 'parent_id');
    }
}
