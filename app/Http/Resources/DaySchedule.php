<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Service;
class DaySchedule extends JsonResource
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
            'location_id'=>$this->location_id,
            'services'=>$this->services,
            'servicecategory'=> optional($this->services)->servicecategory,
            'employees'=>$this->employee,
            'status'=>$this->trashed()?'INACTIVE':'ACTIVE',
            'scheduledtime'=>$this->scheduledtime,
            'schedulecode'=>$this->scheduledcode
           
        ];
    }

      public function with($request)
    {
        return [
            'status'=>201];
    }
}
