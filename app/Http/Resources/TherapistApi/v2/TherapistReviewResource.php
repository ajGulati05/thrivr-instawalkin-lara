<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UsersApi\v2\ChildrenReviewResource;

class TherapistReviewResource extends JsonResource
{

 
    public function toArray($request)
    {

   
   
        return [
           'id'=>$this->id,
            'firstname'=>$this->reviewable->profiles->firstname,
            'lastname'=>$this->reviewable->profiles->lastname,
            'created_at'=>Carbon::parse($this->created_at,'UTC')->isoFormat('MMM Do, YYYY'),
            'body'=>$this->comment,
          //  'replies'=>ChildrenReviewResource::collection($this->replies->load('reviewable.profiles')),
            'verified'=>$this->verified,
            'avatar'=>$this->reviewable->profiles->avatar,
            'booking_slug'=>optional($this->bookings)->tmekit_booking_id,
            'endorsements'=>optional($this->endorsements)->pluck('id'),
            'feedback'=>optional($this->personalFeedback)->user_comment,
            'booking_date'=>Carbon::parse(optional($this->bookings)->start,'UTC')->isoFormat('MMM Do, YYYY'),
            'instauuid'=>$this->instauuid
            ];
    }
}