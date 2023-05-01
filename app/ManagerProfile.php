<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class ManagerProfile extends Model
{
  use SoftDeletes;
  use SpatialTrait;
  protected $dates = ['deleted_at'];


  protected $fillable = [
    'address', 'phone', 'city', 'province',
    'postal_code', 'longitude', 'latitude', 'parking', 'tag_line','address_description','parking_description','about','direct_billing','ics'
  ];
  protected $casts = [
    'parking' => 'boolean',
    'direct_billing'=>'boolean',
    'taking_clients'=>'boolean',
    'add_buffer_to_duration'=>'boolean'

  ];
    protected $spatialFields = [
        'position'
    ];


public function setAddBufferToDuration($value){
     if ($value == true) {
      $this->attributes['add_buffer_to_duration'] = 1;
    } else {
      $this->attributes['add_buffer_to_duration'] = 0;
    }
}
  public function setTakingClientsAttribute($value)
  {
    if ($value == true) {
      $this->attributes['taking_clients'] = 1;
    } else {
      $this->attributes['taking_clients'] = 0;
    }
  }
  public function setParkingAttribute($value)
  {
    if ($value == true) {
      $this->attributes['parking'] = 1;
    } else {
      $this->attributes['parking'] = 0;
    }
  }
 public function setDirectBillingAttribute($value)
  {
    if ($value == true) {
      $this->attributes['direct_billing'] = 1;
    } else {
      $this->attributes['direct_billing'] = 0;
    }
  }
  public function managers()
  {
    return $this->belongsTo('App\Manager', 'manager_id');
  }



  public function scopeGetdistance($query, $lat, $lng)
  {

    return $query->select()->selectRaw("
       ST_Distance_Sphere(
            position,
            point(?, ?)
        ) *0.001 as distance
    ", [
         $lng,
        $lat
       
    ])->get();
     
  /*$position=new Point($lat,$lng,4326);

   $haversine = "(ST_Distance_Sphere(POINT(-73.9949,40.7501), POINT( -73.9961,40.7542))";


    return $query
      ->select() //pick the columns you want here.
      ->selectRaw("{$haversine} AS distance")
      ->get();*/
     
  }


  
}


   /* $haversine = "(6371 * acos(cos(radians($lat)) 
                     * cos(radians(manager_profiles.latitude)) 
                     * cos(radians(manager_profiles.longitude) 
                     - radians($lng)) 
                     + sin(radians($lat)) 
                     * sin(radians(manager_profiles.latitude))))";*/