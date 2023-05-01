<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Gender;
use App\Http\Resources\Service;
class Employee extends JsonResource
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
            'id'=>$this->id,
            'firstname'=>$this->firstname,
            'lastname'=>$this->lastname,
            'licenseno'=>$this->licenseno,
            'gender'=> Gender::make($this->gender)->description,
            'status'=>$this->trashed()?'INACTIVE':'ACTIVE',
            'phone'=>$this->phone,
            'email'=>$this->email,
            'notificationcode'=>$this->notificationcode,
            'service'=>Service::collection($this->services),
           
        ];
    
    }
}
