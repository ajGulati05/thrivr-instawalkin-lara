<?php

namespace App\Http\Resources\UsersApi\v2;
use App\Booking;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UsersApi\v2\BookingPricingResource;
use App\Http\Resources\UsersApi\v2\UserSplitBookingPricingResource;
use App\Http\Resources\CommonResources\v2\ManagerSpecialitiesResource;
class BookingResource extends JsonResource
{


    public function toArray($request)
    {



        return [
            'booking_slug'=>$this->timekit_booking_id,
            'id'=>$this->id,
            'therapist_slug'=>$this->manager->slug,
            'therapist_name'=>$this->manager->first_name.' '.$this->manager->last_name,
            'therapist_photo'=>config('app.s3_bucket_address').$this->manager->profile_photo,
            'therapist_business_name'=>$this->manager->business_name,
            'therapist_slug'=>$this->manager->slug,
       		'address'=>$this->manager->profiles->address,
       		'address_description'=>$this->manager->profiles->address_description,
            'parking'=>$this->manager->profiles->parking,
            'parking_description'=>$this->manager->profiles->parking_description,
            'latitude'=>$this->manager->profiles->latitude,
            'longitude'=>$this->manager->profiles->longitude,
            'massage_start'=>Carbon::parse($this->start,'UTC')->setTimezone($this->manager->timezone)->isoFormat('MMM Do, h:mm a'),
            'massage_start_full_time'=>Carbon::parse($this->start,'UTC')->setTimezone($this->manager->timezone)->toDateTimeString(),
            'massage_timezone'=>$this->manager->timezone,
            'paid_by'=>optional($this->paymentTypes)->description?:'Credit Card',
            "paid_by_2"=>optional($this->paymentTypesTwo)->description,
            'created_at'=>Carbon::parse($this->created_at,'UTC')->setTimezone($this->manager->timezone)->isoFormat('MMM Do, h:mm a'),
       		"pricing"=>new BookingPricingResource($this->activeBookingPricing[0]),
            "status"=>$this->booking_status=='C'?'Cancelled':($this->booking_status==='R'?'Rescheduled':'Booked'),
            "speciality"=> new ManagerSpecialitiesResource(optional($this->managerSpeciality)),
            "project_id"=> $this->project_id,
            'guest'=>optional($this->userGuests)->name,
            'closed'=>$this->isClosed(),
            'modified'=>$this->isModifed(),
            'hasEnded'=>$this->hasEnded(),
            'canTip'=>$this->paid_by==Booking::PAID_BY_CREDIT_CARD?true:false,
            "paid_by_code"=>$this->paid_by,
            "paid_by_2_code"=>$this->paid_by_2,
            "total_amount"=>$this->getBookingTotal(),
            "splitPricing"=> new UserSplitBookingPricingResource($this->topActiveBookingPricing()),
            "lessThan24"=>Carbon::now()->diffInHours(Carbon::parse($this->start))>24?false:true,
            "showFormLink"=>is_null($this->latestCovidForm)
            ];
    }
}




