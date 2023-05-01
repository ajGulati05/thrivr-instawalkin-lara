<?php

namespace App;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
use App\Notifications\GuestVerification;
use App\Notifications\GuestAcceptance;
class Guest extends Model
{

	use  Notifiable,SnoozeNotifiable;
  protected $appends = ['fullName','firstNameValue','phoneValue'];


     protected $casts = [
          'user_exists' => 'boolean',
          'migrated' => 'boolean'
      ];




    public function getPhoneValueAttribute()
  { 
    return $this->phone;
  } 

 public function setUserExsistsAttribute($value)
  {
    if ($value == true) {
      $this->attributes['user_exists'] = 1;
    } else {
      $this->attributes['user_exists'] = 0;
    }
  }

 public function setMigratedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['migrated'] = 1;
    } else {
      $this->attributes['migrated'] = 0;
    }
  }

    public function getFirstNameValueAttribute()
  { 
    return $this->firstname;
  }
    protected $fillable = [
        "email", "firstname","lastname","phone","instauuid"
    ];

    public function books()
    {
        return $this->morphMany('App\Booking', 'bookable');
    }

  public function getFullNameAttribute()
  { 
    return $this->firstname.' '.$this->lastname;
  } 
  

    public function latestBooking(){
        return $this->books()->latest()->first();
    }
   

      public function latestBookingByManager(){
        return "x";
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



    public function user(){
      return $this->belongsTo('App\User');
    }

//Scope Filter for getting guests
    public function scopeFilterGuests(Builder $query, $value): Builder
{
    return $query->whereNull('firstname')
          ->orWhere('firstname', 'like' ,'%'.$value.'%')
       ->whereNull('lastname')
         ->orWhere('lastname', 'like' ,'%'.$value.'%');
}


/**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new GuestVerification($this->firstname,$this->manager));
    }
    /**
     * Send the email for accepting a therapist.
     *
     * @return void
     */
    public function sendEmailAcceptanceNotification()
    {
        $this->notify(new GuestAcceptance($this->firstname,$this->manager));
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }



    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }


    public function manager(){
        return $this->belongsTo('App\Manager');
    }


    public function scopeNotuser($query){
        return $query->whereNull('user_id');
    }

    
    public function chart()
      {
        return $this->morphMany('App\Chart', 'chartable');
      }
    public function chartWithChildren()
      {
        return $this->chart()->with('children');
      }


  public function emailFutureReminder(){
           $notifiableVia=[];
      
          if($this->future_reminder){
            array_push($notifiableVia,"mail");
          }
        

        return $notifiableVia;
    }
}
