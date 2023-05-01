<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'description', 'timekit_project_id',
    'slug', 'length', 'buffer'
  ];
  protected $casts = [
    'default' => 'boolean'
  ];
  public function setDefaultAttribute($value)
  {
    if ($value == true) {
      $this->attributes['default'] = 1;
    } else {
      $this->attributes['default'] = 0;
    }
  }
  public function setMobileNameAttribute($value)
  {

    $this->attributes['mobile_name'] = strtoupper($value);
  }
  public function managers()
  {
    return $this
      ->belongsToMany(Manager::class, 'managers_projects', 'project_id')
      ->using(ManagerProject::class)
      ->withPivot('project_id');
  }

  public function project_pricings()
  {
    return $this->hasMany(ProjectPricing::class);
  }

  public function activeprojectpricing()
  {
    return $this->project_pricings()->activepricing();
  }

  public function activeAllProductManagers(){
  return $this->managers()->active()->allProduct();
  }

  public function activeManagers(){
      return $this->managers();
  }
   public function activeListingManagers(){
      return $this->managers()->active()->listing();
  }
}
