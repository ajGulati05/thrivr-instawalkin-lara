<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Gabievi\Promocodes\Traits\Rewardable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Vendor_override\CustomResetPasswordEmail;
use App\Notifications\CustomUserVerificationEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
use App\Http\Traits\v2\UserReferralTrait;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, SnoozeNotifiable;
    use  Notifiable, Rewardable;
    use UserReferralTrait;

    protected $guard = 'users';
   /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','provider','provider_id','instauuid','email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

  protected $appends = ['fullName','firstNameValue','lastNameValue','phoneValue'];

    public function getPhoneValueAttribute()
  { 
    return $this->profiles->phone;
  } 
    public function getFirstNameValueAttribute()
  { 
    return $this->profiles->firstname;
  } 
      public function getLastNameValueAttribute()
  { 
    return $this->profiles->lastname;
  } 
   public function getFullNameAttribute()
  { 
    return $this->profiles->firstname.' '.$this->profiles->lastname;
  } 
    public function corporationpromousers()
    {
        return $this->hasOne(CorporationpromoUser::class, 'users_id', 'id');
    }


    public function userprofiles()
    {
        return $this->hasOne(Userprofile::class, 'user_id', 'id')->withDefault([
            'firstname' => null, 'lastname' => null, 'phone' => null, 'expotoken' => null
        ]);
    }


        /**TODO take with default out and fix user response****/
    public function stripedata()
    {
        return $this->hasOne(Stripedata::class)->withDefault([
            'stripe_id' => null, 'card_brand' => null, 'card_last_four' => null
        ]);
    }


        /**TODO take with default out and fix user response****/
    public function creditcards()
    {
        return $this->hasMany(Stripedata::class);
    }

  

    public function usernotifications()
    {
        return $this->hasOne(UserNotifications::class);
    }

    public function usercredits()
    {
        return $this->hasOne(Usercredits::class, 'user_id', 'id')->withDefault([
            'amount' => 0
        ]);
    }
    public function promocodehistory()
    {
        return $this->hasOne(Promocodehistory::class, 'user_id', 'id')->withDefault([
            'amount' => 0
        ]);
    }

    public function holdingtransactions()
    {
        return $this->hasMany(Holdingtransactions::class, 'user_id', 'id');
    }

    public function books()
    {
        return $this->morphMany('App\Booking', 'bookable');
    }

 public function blockedByManagers()
    {
        return $this->belongsToMany(Manager::class,'blocked_users','user_id','manager_id');
    }

/**
     * Get all of the post's comments.
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
  public function profiles()
    {
        return $this->hasOne(Userprofile::class, 'user_id', 'id')->withDefault([
            'firstname' => null, 'lastname' => null, 'phone' => null, 'expotoken' => null
        ]);
    }
 

    public function countUserHaveBookings(){
            return $this->books()->count();
    }

    public function hasWrittenReviewForManager($manager_id){
    
            return $this->reviews->contains($manager_id);
        }
        public function userGuests(){
            return $this->hasMany(UserGuest::class);
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
        $this->notify(new CustomResetPasswordEmail(config('constants.urls.webapp').'/reset-password?token='.$token,$this->profiles->firstname));
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


    public function latestBooking(){
        return $this->books()->latest()->first();
    }
   

      public function bookingsByManager($id){
        return $this->books()->where('manager_id',$id);
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


    public function routeNotificationForTwilio()
        {
            return $this->profiles->phone;
        }

/**
     * Get all of the post's comments.
     */
    public function intakeformsActive()
    {
        return $this->intakeforms()->active();
    }
     



 /**
     * The users that belong to the role.
     */
    public function managers()
    {
               return $this->belongsToMany('App\Manager','client_therapist','user_id','manager_id')->withTimestamps();
                     
    }




  /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomUserVerificationEmail($this->profiles->firstname));
    }



    public function chart()
      {
        return $this->morphMany('App\Chart', 'chartable');
      }

        public function chartWithChildren()
      {
        return $this->chart()->with('children');
      }
//Returns the user that rewarded the current user
public function rewardee(){
    return $this->belongsTo('App\User', 'referred_by','affiliate_id');
}


public function rewardEmails(){
    return $this->hasMany('App\RewardEmail');
}


public function rewardHistories(){
    return $this->hasMany('App\RewardHistory');
}

public function rewards(){
    return $this->hasOne('App\UserReward')->withDefault([
            'debit' => null, 'credit' => null
        ]);
}

    // Date since when a credit card was required to create a booking to cover cancelation and rescheduling fees if needed.
    public function forceRequireCreditCard(){
        $date = $this->created_at;
        $releaseDate = Carbon::parse('2021-08-29');
        // require a credit card if user has not yet setup a credit or the user's account was created after the change was introduce  (2021-08-29)
        return $this->stripedata->stripe_id || !$date->gte($releaseDate) ?FALSE:TRUE;
        
    }
}
