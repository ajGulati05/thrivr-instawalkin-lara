<?php
declare(strict_types=1);
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Abstracts\UuidModel;
use Illuminate\Support\Str;
use Roelofr\EncryptionCast\Casts\EncryptedAttribute;

class CovidForm extends UuidModel
{
    protected $guarded=[];
    protected $casts = [
       
        'active' =>'boolean' ,
        'testing' => EncryptedAttribute::class.':collection',
        'name' => EncryptedAttribute::class.':collection',
        'symptoms' => EncryptedAttribute::class.':collection',
        'exposure' => EncryptedAttribute::class.':collection',
        'travel' => EncryptedAttribute::class.':collection',
        'precautions' => EncryptedAttribute::class.':collection',
        'contact' => EncryptedAttribute::class.':collection',
        'actions' => EncryptedAttribute::class.':collection',
        'consent' =>'boolean'
    ];


       /**
     * Get the owning imageable model.
     */
    public function covidformable()
    {
        return $this->morphTo();
    }

    public function scopeActive($query){
            return $query->where('active',1);
    }

      public function bookings(){
        return $this->belongsToMany('App\Booking','booking_covid_forms','covidform_id','booking_id')->withTimestamps();
    }
}
