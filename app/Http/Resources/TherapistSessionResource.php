<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class TherapistSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // Log::debug($this->manager);

    
            return [
                "username"=>'hello',
                "token"=>$this->access_token,
                "access_token" => $this->access_token,
                "refresh_token" => $this->refresh_token,
                "expires_in" => $this->expires_in,
                "token_type" => $this->token_type,
                "timekit_resource_id" => $this->manager->timekit_resource_id, //this could be change
                "address" => $this->managerProfile->address,
                "manager_id"=>$this->manager->id
       ];

       
    }
}
