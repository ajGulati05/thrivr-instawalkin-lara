<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\v2\CanSaveQuietly;
class Booking extends Model
{

use CanSaveQuietly;
public const PAID_BY_CREDIT_CARD='CR';
public const RESCHEDULED_BOOKING_STATUS='R';
public const CANCELLED_BOOKING_STATUS='C';
public const DELETED_BOOKING_STATUS='D';

public const BOOKED_BY_THERAPIST='MANAGER';
public const BOOKED_BY_USER='USER';
public const BOOKED_BY_ADMIN='USER';

public const BOOKED_USING_PROMO_CODE='P';
public const BOOKED_USING_REFERRAL_CODE='R';

public const RESCHEDULE_FEE_PERCENTAGE= 0.50;
public const CANCEL_FEE_PERCENTAGE = 1;

    protected $fillable = [
        'user_id', 'manager_id', "project_id",
        "start", "end", "timekit_booking_id",
        "bookable_id", "bookable_type",
        "app_source", "by_source", 'paid_by',
        "project_pricing_id", "booking_status",
        "status_changed_date", "status_initiated_on",
        "status_initiated_by", "status_changed_by",
        'when', 'date_to_authorize', 'manager_speciality_id',"closed","userguest_id","paid_by_2","discount_type"
    ];
     protected $casts = [
    'closed' => 'boolean'
  ];
  protected $appends = ['latestCovidForm'];
  public function setClosedAttribute($value)
  {
    if ($value == true) {
      $this->attributes['closed'] = 1;
    } else {
      $this->attributes['closed'] = 0;
    }
  }
    public function bookable()
    {
        return $this->morphTo();
    }

    public function userGuests(){
      return $this->hasOne(UserGuest::class,'id','userguest_id');
    }

     public function scopeUsers($query)
    {
        return $query->where('bookable_type', 'App\User');
    }

      public function scopeUserType($query)
    {
        return $query->where('bookable_type', 'App\User');
    }


       public function scopeGuestType($query)
    {
        return $query->where('bookable_type', 'App\Guest');
    }

    public function booking_pricings()
    {
        return $this->hasMany(BookingPricing::class);
    }

    public function activeBookingPricing()
    {

        return $this->booking_pricings()->activeBookingPricing();
    }

      public function topActiveBookingPricing()
    {

        return $this->activeBookingPricing()->first();
    }
  public function firstActiveBookingPricing()
    {

        return $this->booking_pricings()->activeBookingPricing()->first();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id', 'id')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id')->withDefault();
    }
      public function receipts()
    {
        return $this->hasMany(Receipt::class, 'booking_id');
    }
    public function managerSpeciality()
    {
        return $this->belongsTo(ManagerSpeciality::class, 'manager_speciality_id', 'id')->withDefault();
    }

        public function scopeFilter($query, $filters)
    {


        if ($startdate = $filters['startdate']) {
            $enddate = $filters['enddate'];
            $query->whereBetween('start', [$startdate, $enddate]);
        }
    }
      public function scopeBookingByManager($query, $manager_id)
    {

            return $query->where('manager_id', $manager_id);

    }

       public function scopeUpcomingBooking($query,$id)
    {

           return $query->bookingByManager($id)->where('start','>',Carbon::now())->oldest('start')->first();

            //get all bookings above todays/datetime
            //order by asc grab first

    }

        public function scopeLastBooking($query,$id)
    {

                 return $query->bookingByManager($id)->where('start','<',Carbon::now())
                ->latest('start')->first();

    }

   public function reviews(){
    return $this->hasOne(Review::class);
   }


   public function isPaymentCredit(){
    return $this->paid_by=='CR';
   }

   public function getCreditCard(){
        if($this->isPaymentCredit())
        {
            return $this->firstActiveBookingPricing()->firstActiveBookingTransaction();
             }

        return false;
   }



    public function scopeDateBetweens($query, $start,$end)
    {
            $start=Carbon::parse($start)->startOfDay();
             $end=Carbon::parse($end)->endOfDay();
           return  $query->whereBetween('start',[$start,$end]);

    }

    public function covidForms(){
        return $this->belongsToMany('App\CovidForm','booking_covid_forms','booking_id','covidform_id')->withTimestamps();
    }
     public function getLatestCovidFormAttribute()
  {
    return $this->covidForms()->first();
  }



    public function isModifed()
    {
      return isset($this->booking_status);
    }

      public function isClosed()
    {
      return $this->closed;
    }


    public function hasEnded()
    {
      return Carbon::now()->gt($this->end);
    }


    public function paymentTypes(){
       return $this->belongsTo(PaymentType::class,'paid_by','code');
    }

 public function paymentTypesTwo(){
       return $this->belongsTo(PaymentType::class,'paid_by_2','code');
    }

public function getMassageDate(){

    $timeZone=$this->manager->timezone?:'America/Regina';

    return Carbon::parse($this->start, 'UTC')->setTimezone($timeZone)->isoFormat('MMM Do, h:mm a');
}

public function isGuest(){
    return ($this->bookable instanceOf \App\Guest);
}

public function hasUserGuest(){
  return isset($this->userguest_id);
}

public function getPaidBy(){
  return $this->paid_by=='CR'?' Credit card - and will be automatically processed via Thrivr':$this->paymentTypes->description;
}


public function getMassageDateWithYear(){

    $timeZone=$this->manager->timezone?:'America/Regina';

    return Carbon::parse($this->start, 'UTC')->setTimezone($timeZone)->isoFormat('MMM Do YYYY');
}

public function getMassageEndDate(){

        $timeZone=$this->manager->timezone?:'America/Regina';

        return Carbon::parse($this->end, 'UTC')->setTimezone($timeZone);
  }

    public function getMassageStartDate(){

        $timeZone=$this->manager->timezone?:'America/Regina';

        return Carbon::parse($this->start, 'UTC')->setTimezone($timeZone);
    }
//Booking Add Ons
  public function bookingAddOns(){
        return $this->hasMany(BookingAddOn::class);
      }


  public function activeBookingAddOns(){
    return $this->bookingAddOns()->active();
  }


//function to show booking is by manager

  public function scopeIsBookingByManager(){

    return $this->where('by_source',Booking::BOOKED_BY_THERAPIST);
  }


public function getBookingTotal(){




      $bookingPricingsSum=DB::table('booking_pricings')
             ->select(DB::raw('IFNULL(sum(amount),0)+IFNULL(sum(tax_amount),0)-ifnull(sum(discount_amount),0) as total'))
             ->where('booking_id',$this->id)
             ->where('active',true)
             ->first();

       $bookingAddOnsSum=DB::table('booking_add_ons')
             ->select(DB::raw('IFNULL(sum(amount),0)+IFNULL(sum(tax_amount),0) as total'))
             ->where('booking_id',$this->id)
             ->where('active',true)
             ->first();



      return$bookingPricingsSum->total+$bookingAddOnsSum->total;



}

}
