<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGuest extends Model
{
    //

    protected $fillable=["name","instauuid"];

    protected $appends = ['fullName','firstNameValue'];

    public function getFirstNameValueAttribute()
  { 
    return $this->splitNames($this->name)[0];
  }
 public function getFullNameAttribute()
  { 
    return $this->name;
  } 
  /**
     * Get all of the post's comments.
     */
    public function intakeforms()
    {
        return $this->morphMany('App\IntakeForm', 'intakeformable');
    }

  /**
     * Get all of the post's comments.
     */
    public function covidforms()
    {
        return $this->morphMany('App\CovidForm', 'covidformable');
    }




    public function splitNames($name){

        $returnName=explode(" ",$name);
        return $returnName;

    }
}
