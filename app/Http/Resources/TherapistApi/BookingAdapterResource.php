<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class BookingAdapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "id"=>$this->id,
            "name"=>$this->bookable->first_name .' '.$this->bookable->last_name,
            "start"=>Carbon::parse($this->start, 'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a'),
            "paid_by"=>$this->paid_by=='CR'?'Credit':'Cash',
            

             
         ];
    }
}
