<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagerSpeciality extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'code', 'description'
    ];
         protected $casts = [
        'default' => 'boolean',
        'speciality_photo_attribute'=>'json'
    ];
public function setDefaultAttribute($value)
    {
    if($value==true){
      $this->attributes['default'] = 1;
    }
    else{
      $this->attributes['default'] = 0;
    }
  }
    public function managers(){
        return $this->belongsToMany('App\Manager','managers_specialities','manager_speciality_id');
    }

}
