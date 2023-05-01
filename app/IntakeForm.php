<?php
declare(strict_types=1);
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Abstracts\UuidModel;
use Illuminate\Support\Str;
use Roelofr\EncryptionCast\Casts\EncryptedAttribute;
class IntakeForm extends UuidModel
{



protected $guarded=[];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'name'=>EncryptedAttribute::class,
        'active' =>'boolean' ,
		    'address'=>EncryptedAttribute::class,
        'phone' => EncryptedAttribute::class,
        'birthdate' => EncryptedAttribute::class,
        'referred_by' => EncryptedAttribute::class,
        'physician_name' => EncryptedAttribute::class,
        'allergies' => EncryptedAttribute::class,
        'sports_activities' => EncryptedAttribute::class,
        'current_medications' => EncryptedAttribute::class,
        'medical_conditions' => EncryptedAttribute::class.':collection',
        'care' => EncryptedAttribute::class.':collection',
        'surgery' => EncryptedAttribute::class.':collection',
        'fractures' => EncryptedAttribute::class.':collection',
        'illness' => EncryptedAttribute::class.':collection',
        'motor_workplace' => EncryptedAttribute::class.':collection',
        'tests' => EncryptedAttribute::class.':collection',
        'relieves' => EncryptedAttribute::class.':collection',
        'aggravates' => EncryptedAttribute::class.':collection',
        'consent' =>'boolean'
    ];
     /**
     * Get the owning imageable model.
     */
    public function intakeformable()
    {
        return $this->morphTo();
    }

    public function scopeActive($query){
            return $query->where('active',1);
    }

      public function managers(){
        return $this->belongsToMany('App\Manager','intake_forms_manager','intakeform_id','manager_id')->withTimestamps();
    }

     public function userGuests(){
      return $this->hasOne(UserGuest::class,'id','userguest_id');
    }



      public function scopeUserType($query)
    {
        return $query->where('intakeformable_type', 'App\User');
    }

   
       public function scopeGuestType($query)
    {
        return $query->where('intakeformable_type', 'App\Guest');
    }
}
 
      