<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Service;
class DayScheduleRedis extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->services){
         return [
            'id'=>$this->id,
            'location_id'=>$this->location_id,
            'services'=>optional($this->services)->id,
            'servicecategory'=> optional($this->services)->servicecategory->id,
            'employees'=>optional($this->employee)->id,
            'status'=>$this->trashed()?'INACTIVE':'ACTIVE',
            'scheduledtime'=>$this->scheduledtime,
            'schedulecode'=>$this->scheduledcode
           
        ];
    }
    else{
        return [
            'id'=>$this->id,
            'location_id'=>$this->location_id,
            'services'=>optional($this->services)->id,
            'servicecategory'=> null,
            'employees'=>optional($this->employee)->id,
            'status'=>$this->trashed()?'INACTIVE':'ACTIVE',
            'scheduledtime'=>$this->scheduledtime,
            'schedulecode'=>$this->scheduledcode];
    }
    }

      public function with($request)
    {
        return [
            'status'=>201];
    }
}
