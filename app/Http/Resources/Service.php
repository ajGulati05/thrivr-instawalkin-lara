<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Tax;
use App\Http\Resources\ServiceCategory;
class Service extends JsonResource
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
            'amount'=>$this->amount,
            'taxamount'=>number_format((float)$this->amount+ ($this->amount*Tax::collection($this->taxes)->sum('taxpercent')/100), 2, '.', ''),
            'status'=>$this->status,
            'service_id'=>  optional($this->getServiceName)->id,//service category id
            'servicename'=>  optional($this->getServiceName)->description,
            'taxes'=>Tax::collection($this->taxes),
            'altdescription'=>$this->altdescription
        ];
    }
}
