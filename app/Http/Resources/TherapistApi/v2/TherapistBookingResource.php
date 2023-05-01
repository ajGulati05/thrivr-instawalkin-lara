<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\v2\TherapistClientResource;
use App\Http\Resources\TherapistApi\v2\TherapistClientGuestResource;
use App\Http\Resources\TherapistApi\v2\TherapistBookingPricingResource;
use App\Http\Resources\TherapistApi\v2\TherapistBookingAddOnResource;
use App\User;
use App\Guest;
use App\Http\Resources\CommonResources\v2\CovidFormUnEncryptedDetailResource;
use App\Http\Resources\CommonResources\v2\ProjectResource;
class TherapistBookingResource extends JsonResource
{

    protected $timezone;
    protected $buffer;
    protected $bufferString;
    protected $manager;
  
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->manager=Auth::user();
        $this->timezone=$this->manager->timezone;
        $this->bufferString=$this->manager->availabilityConstraint->end_buffer;
     
        return [
            "id"=>$this->id,
            "slug"=>$this->timekit_booking_id,
         
            "modality_description"=>optional($this->managerSpeciality)->description,
            "start_datetime"=>Carbon::parse($this->start, 'UTC')->setTimezone($this->timezone)->toDateTimeString(),
            "end"=>Carbon::parse($this->end, 'UTC')->setTimezone($this->timezone)->toDateTimeString(),
            "client"=>$this->bookable_type==User::class?new TherapistClientResource($this->bookable):new TherapistGuestResource($this->bookable),
            "client_guest"=>new TherapistClientGuestResource($this->userGuests),
            "type"=>$this->bookable_type==User::class?"Client":"Guest",
            "created_at"=>Carbon::parse($this->created_at, 'UTC')->setTimezone($this->timezone)->isoFormat('MMM Do, h:mm a'),
            "updated_at"=>Carbon::parse($this->updated_at, 'UTC')->setTimezone($this->timezone)->isoFormat('MMM Do, h:mm a'),
            "start"=>Carbon::parse($this->start, 'UTC')->setTimezone($this->timezone)->isoFormat('MMM Do, h:mm a'),
            "paid_by_description"=>optional($this->paymentTypes)->description?:'Credit Card',
            "paid_by_2_description"=>optional($this->paymentTypesTwo)->description,
            "total_amount"=>$this->getBookingTotal(),
            "pricing"=>new TherapistBookingPricingResource($this->topActiveBookingPricing()),
            "status"=>$this->booking_status=='C'?'Cancelled':($this->booking_status==='R'?'Rescheduled':'Booked'),
            "covid_form"=>new CovidFormUnEncryptedDetailResource($this->latestCovidForm),
            "project"=>new ProjectResource($this->project),
            'closed'=>$this->isClosed()?:false,
            'modified'=>$this->isModifed(),
            'hasEnded'=>$this->hasEnded(),
            'canBeCancelled'=>!$this->isClosed()||!$this->isModifed(),
            'canBeModified'=>!$this->isClosed()||!$this->isModifed(),
            'canSendReceipt'=>$this->isClosed()||$this->isModifed(),
            'canChangePay'=>!$this->isClosed(),
            'canAddTip'=>!$this->isClosed(),
            'addOns'=>TherapistBookingAddOnResource::collection(optional($this->bookingAddOns)),
            'splitPricing'=> new TherapistSplitBookingPricingResource($this->topActiveBookingPricing()),
            "paid_by"=>$this->paid_by,
            "paid_by_2"=>$this->paid_by_2,
            "manager_speciality_id"=>$this->managerSpeciality,
        

          //  'bookingAddOns'=>TherapistBookingAddOnResource($this->bookingAddOns)

         ];
    }
}
