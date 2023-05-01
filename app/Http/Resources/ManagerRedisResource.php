<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationRedis;
use App\Http\Resources\ManagerNotifications;
class ManagerRedisResource extends JsonResource
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
            'email'=>$this->email,
            'status'=>$this->status,
            'locations'=>new LocationRedis($this->locations),
            
         ];

    }
}
