<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\Vendor_override\CustomResetPasswordEmail;
use App\Notifications\VerifyManagersEmail;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\User;
use App\Booking;
use Illuminate\Database\Eloquent\Relations\Relation;


use Illuminate\Support\Facades\Log;
class Manager extends Authenticatable 
{

   public const BIG_AVATAR_WIDTH=94;
   public const BIG_AVATAR_HEIGHT=94;
   public const SMALL_AVATAR_WIDTH=94;
   public const SMALL_AVATAR_HEIGHT=94;
   


      public const ALL_PRODUCTS="A";


    protected $guard = 'managersapi';// this is a new guard
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    use HasSlug;
   
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'timekit_resource_id',
        'gender', 'first_name', 'last_name','business_name','profile_photo','product_code','status',
        'mini_avatar','mini_avatar_attributes','avatar_attributes','show_reviews'

    ];
    protected $appends = ['fullName'];
    protected $hidden = [
        'password', 'remember_token',
    ];

 
    public function getFullNameAttribute()
  { 
    return $this->first_name.' '.$this->last_name;
  }    

public function sendEmailVerificationNotification()
{   

    Log::debug("hello");
  //  $this->notify(new VerifyManagersEmail());
}    

public function getSlugOptions()
{
    return SlugOptions::create()
        ->generateSlugsFrom(['first_name', 'last_name','business_name'])
        ->saveSlugsTo('slug')
         ->usingSeparator('_');
}


    protected $casts = [
        'status' => 'boolean',
        'emailsent' => 'boolean',
        'emailconfirmed' => 'boolean',
        'first_login'=>'boolean',
        'skip'=>'boolean',
        'calendar_sync'=>'boolean',
        'avatar_attributes'=>'json',
        'mini_avatar_attributes'=>'json',
        'show_reviews'=>'boolean'

    ];
   /* public function getStatusAttribute($value)
    {


        if ($value == 1) {
            return  'ACTIVE';
        } else {
            return  'INACTIVE';
        }
    }*/


  public function setFirstLoginAttribute($value)
  {
    if ($value == true) {
      $this->attributes['first_login'] = 1;
    } else {
      $this->attributes['first_login'] = 0;
    }
  }
  public function setCalendarSyncAttribute($value)
  {
    if ($value == true) {
      $this->attributes['calendar_sync'] = 1;
    } else {
      $this->attributes['calendar_sync'] = 0;
    }
  }
  public function setStatusAttribute($value)
  {
    if ($value == true) {
      $this->attributes['status'] = 1;
    } else {
      $this->attributes['status'] = 0;
    }
  }
    public function setShowReviewsAttribute($value)
    {
        if ($value == true) {
            $this->attributes['show_reviews'] = 1;
        } else {
            $this->attributes['show_reviews'] = 0;
        }
    }

  public function setSkipAttribute($value)
  {
    if ($value == true) {
      $this->attributes['skip'] = 1;
    } else {
      $this->attributes['skip'] = 0;
    }
  }
    public function genders()
    {
        return $this->belongsTo(Gender::class, 'code', 'gender');
    }
    public function getEmailconfirmedAttribute($value)
    {

        if ($value == 1) {
            return  'YES';
        } else {
            return 'NO';
        }
    }

    public function getEmailsentAttribute($value)
    {


        if ($value == 1) {
            return 'YES';
        } else {
            return 'NO';
        }
    }

    public function adminlocations()
    {
        return $this->hasOne(Location::class)->withDefault([
            'name' => 'Create Partner Location', 'locationtype' => ['description' => 'Create Partner Location'], 'id' => '0'
        ]);
    }

    public function locations()
    {
        return $this->hasOne(Location::class)->withDefault([
            'name' => 'Create Partner Location',
        ]);
    }
    public function managernotifications()
    {
        return $this->hasOne(ManagerNotifications::class,'manager_id');
    }

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public function projects()
    {
        return $this
            ->belongsToMany(Project::class, 'managers_projects', 'manager_id')
            ->using(ManagerProject::class)
            ->withPivot('manager_id');
    }

    public function manager_licenses()
    {
        return $this->hasMany('App\ManagerLicense', 'manager_id');
    }
    public function manager_profiles()
    {
        return $this->hasOne('App\ManagerProfile', 'manager_id');
    }
    
       public function profiles()
    {
        return $this->hasOne('App\ManagerProfile', 'manager_id');
    }
    public function manager_specialities()
    {
        return $this->belongsToMany('App\ManagerSpeciality', 'managers_specialities', 'manager_id');
    }
      public function managerspecialities()
    {
        return $this->belongsToMany('App\ManagerSpeciality', 'managers_specialities', 'manager_id');
    }


    //this also may not be used
    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }

    //I am not sure if this is necessary
    // fix the spellings marco - AJ
    public function AauthAcessToken()
    {
        return $this->hasMany(OauthAccessToken::class, 'user_id');
    }
    public function bookings(){
        return $this->hasMany('App\Booking','manager_id');
    }
    public function activemanagerlicense(){
        return $this->manager_licenses()->activeManagerLicense();
}

  public function secondary_emails()
    {
        return $this->belongsToMany('App\SecondaryEmails','manager_secondary_email','manager_id');
    }
 public function rmt_teams()
    {
        return $this->belongsToMany('App\RmtTeam','managerrmtteams','manager_id');
    }
public function blockedUsers()
    {
        return $this->belongsToMany(User::class,'blocked_users','manager_id','user_id')->withTimestamps();
    }
   public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
   
 
   public function scopeAllProduct($query)
    {
        return $query->where('product_code', 'A');
    }

 public function scopeListing($query)
    {
        return $query->where('product_code', 'L');
    }
   

   public function availabilityConstraint(){
    return $this->hasOne(AvailabilityConstraint::class);
   }

public function reviews()
{
    return $this->hasMany('App\Review','manager_id')->with('reviewable');
}

public function verifiedReviews(){
    return $this->hasMany('App\Review','manager_id')->verified();
}

public function unverifiedReviews(){
    return $this->hasMany('App\Review','manager_id')->unverified();
}

public function reviewCount(){
       return $this->reviews()->count();
}

public function reviewScore(){
    //TODO right now verified reviews and unverified reveiws are counted the same. Need to figure out a better way  to create a score. 

        $score=0;
       if(!$this->reviewCount()==0){
         $score=($this->reviews()->sum('score')/$this->reviewCount());
       }

       return number_format((float)$score, 1, '.', '');
         
}

    public function commentsFrom()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }

 public function endorsements()
    {
        return $this->hasManyThrough('App\Pivots\EndorsementReview', 'App\Review');
    }
 public function verifiedEndorsements()
    {
        return $this->endorsements()->with('verifiedreviews');
    }


public function unverifiedEndorsements()
    {
        return $this->endorsements()->with('unverifiedreviews');
    }
 public function endorsementsWithReviews()
    {
        return $this->endorsements()->with('reviews');
    }

 public function isListingManager()
    {
        return $this->product_code=='L';
    }

  public function bookingsBetweenDate($start,$end){
    return $this->bookings()->dateBetweens($start,$end)->get();
  }  




//For clients 


 public function userBookings(){
    return $this->bookings()->userType();

 }

//Guests

 public function guests(){
    return $this->hasMany('App\Guest');
 }


      /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordEmail(config('therapistadmin.url').config('therapistadmin.reset_password').$token, $this->first_name));
    }
  /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function cartviews()
    {
        return $this->hasMany('App\CartView');
    }


    public function intakeForms(){
        return $this->belongsToMany('App\IntakeForm','intake_forms_manager','manager_id','intakeform_id')->withPivot('active')->withTimestamps();
    }



 /**
     * The users that belong to the role.
     */
    public function clients()
    {
        return $this->belongsToMany('App\User','client_therapist','manager_id','user_id')->withPivot('blocked')->withTimestamps();
                     
    }


    public function userIntakeForms(){
       return $this->intakeForms()->userType();
    
   }
 public function guestIntakeForms(){
       return $this->intakeForms()->guestType();
    
   }


     public function routeNotificationForTwilio()
        {
            return $this->profiles->phone;
        
        }

       /**

     * The roles that belong to the user.

     */

    public function submodalities()

    {

        return $this->belongsToMany('App\SubModalitie', 'manager_submodalities', 'manager_id', 'sub_modalities_code');

    }

/*public function activeBookings(){
  return $this->bookings()->activeBooking();
}

public function activeBookingsByCreditCard(){
  return $this->bookings()->activeBooking()->paidByCreditCard();
}*/


public function guestsNotUser(){
  return $this->guests()->notuser();
}


public function charts(){
  return $this->hasMany('App\Chart');
}

}





