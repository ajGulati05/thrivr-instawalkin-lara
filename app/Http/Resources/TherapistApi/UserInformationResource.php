<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class UserInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
   private $manager;

       /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $manager)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        // Ensure you call the parent constructor
        
        $this->manager = $manager;
        
    }

    public function toArray($request)
    {

        return [
            "id"=>$this->id,
            "email"=>$this->email,
            "first_name"=>$this->userprofiles->firstname,
            "last_name"=>$this->userprofiles->lastname,
            "user_type"=>'User',
            "phone"=>$this->userprofiles->phone,
            "has_credit_card"=>false,
            

            //adding new data 
            "last_appointment"=>Carbon::parse(optional($this->books()->lastBooking($this->manager->id))->start, 'UTC')->setTimezone($this->manager->timezone)->isoFormat('MMM Do, h:mm a'),
            "next_appointment"=>Carbon::parse(optional($this->books()->upcomingBooking($this->manager->id))->start, 'UTC')->setTimezone($this->manager->timezone)->isoFormat('MMM Do, h:mm a'),
            "total_appointments"=>optional($this->books()->bookingByManager($this->manager->id))->count(),
            "status"=> $this->manager->blockedUsers->contains($this->id)

             
         ];
    }
}

