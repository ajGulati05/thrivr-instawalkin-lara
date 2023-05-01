<?php

namespace App\Http\Resources\TherapistApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class TherapistClientGuestResource extends JsonResource
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
            
            "name"=>$this->name,
            "id"=>'ClientGuest:'.$this->instauuid

             
         ];
    }
}
