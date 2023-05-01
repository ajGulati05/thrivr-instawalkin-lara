<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Review extends Model
{
    //
  protected $primaryKey = 'id';

     protected $fillable = [
         'booking_id', 'manager_id','comment','score','parent_id','booking_id','manager_id','reviewable_type','reviewable_id','verified'
    ];
    protected $casts = [
    'verified' => 'boolean'
  ];  

 public function setVerifiedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['verified'] = 1;
    } else {
      $this->attributes['verified'] = 0;
    }
  }

  public function getVerifiedAttribute($value)
  {
    if ($value == 1) {
      return true;
    } 
    else{
    return false;
      }
  }
  public function bookings(){
    return $this->belongsTo('App\Booking');
  }
  public function scopeNotChildren($query)
    {
        return $query->whereNull('parent_id');
    }
  
  public function scopeVerified($query){
  	return $query->where('verified',true);
  }
  public function scopeUnverified($query){
  	return $query->where('verified',false);
  }

   
    public function endorsements()
    {
    	return $this->belongsToMany('App\Endorsement');
    }


     public function replies()
    {
        return $this->hasMany(Review::class,'parent_id');
    }

     /**
     * Get the owning imageable model.
     */
    public function reviewable()
    {
        return $this->morphTo();
    }


     public function scopeSort($query, $sort)
    {
      $sortType=[
        'default'=>['created_at','verified'],
        'latest'=>'created_at',
        'verified'=>'verified',
        'hrating'=>'hrating',
        'lrating'=>'lrating'

      ];
        if($sort=='default'){
          return $query->orderBy('created_at')->orderBy('verified');
        }
         if($sort=='hrating'){
          return $query->orderBy('score','desc');
        }
         if($sort=='lrating'){
          return $query->orderBy('score','asc');
        }
        return $query->orderBy($sortType[$sort]);
    }

    public function personalFeedback(){
      return $this->hasOne('App\PersonalFeedback');
    }




}


