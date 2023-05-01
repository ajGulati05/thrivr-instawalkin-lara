<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\TherapistApi\v2\TherapistClientResource;
use App\Http\Resources\TherapistApi\v2\TherapistClientGuestResource;
use App\User;
class IntakeFormResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           
       			
            
             "created_at"=>Carbon::parse($this->created_at,'UTC')->isoFormat('MMM Do, h:mm a'),
             "client"=>new TherapistClientResource($this->intakeformable),
            "client_guest"=>new TherapistClientGuestResource($this->userGuests),
             "id"=>$this->id,
            
            ];
    }
}




 