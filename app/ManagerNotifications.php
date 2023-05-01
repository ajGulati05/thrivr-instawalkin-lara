<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NotificationChannels\Twilio\TwilioChannel;
class ManagerNotifications extends Model
{
    //
protected $guard='managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         ''
    ];

 protected $casts = [
        'booking_texts' => 'boolean',
        'booking_emails' => 'boolean',
        'review_emails' => 'boolean',
        'endorsement_emails' => 'boolean'
    ];
   
public function managers(){
  return $this->belongsTo('App\Manager');
}
  public function setBoookingTextsAttribute($value)
  {
    if ($value == true) {
      $this->attributes['booking_texts'] = 1;
    } else {
      $this->attributes['booking_texts'] = 0;
    }
  }
  
   public function getBookingTextsAttribute($value)
    {

      
      if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
        
        
        
    }
    public function setBookingEmailsAttribute($value)
  {
    if ($value == true) {
      $this->attributes['booking_emails'] = 1;
    } else {
      $this->attributes['booking_emails'] = 0;
    }
  }
     public function getBookingEmailsAttribute($value)
    {

      
      if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
        
        
        
    }


     public function setReviewEmailsAttribute($value)
  {
    if ($value == true) {
      $this->attributes['review_emails'] = 1;
    } else {
      $this->attributes['review_emails'] = 0;
    }
  }
     public function getReviewEmailsAttribute($value)
    {

      
      if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
        
        
        
    }


     public function setEndorsementEmailsAttribute($value)
  {
    if ($value == true) {
      $this->attributes['endorsement_emails'] = 1;
    } else {
      $this->attributes['endorsement_emails'] = 0;
    }
  }
     public function getEndorsementEmailsAttribute($value)
    {

      
      if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
        
        
        
    }




public function bookingNotifications(){

          $notifiableVia=[];
          if($this->booking_texts){
            array_push($notifiableVia,TwilioChannel::class);
          }

          if($this->booking_emails){
            array_push($notifiableVia,"mail");
          }
        

        return $notifiableVia;

        }


 public function reviewNotifications(){

          $notifiableVia=[];
  

          if($this->review_emails){
            array_push($notifiableVia,"mail");
          }
        

        return $notifiableVia;

        }       

}
