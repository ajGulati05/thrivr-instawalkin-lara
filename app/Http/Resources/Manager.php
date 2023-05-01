<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Location;
use App\Http\Resources\ManagerNotifications;
class Manager extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'email'=>$this->email,
            'status'=>$this->status,
            'locations'=>new Location($this->locations),
             'managernotifications'=> new ManagerNotifications($this->managernotifications),
         ];

    }
}

