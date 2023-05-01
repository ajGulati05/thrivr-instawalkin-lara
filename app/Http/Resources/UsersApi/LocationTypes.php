<?php

namespace App\Http\Resources\UsersApi;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UsersApi\Servicecategories;
class LocationTypes extends JsonResource
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
            "id"=>$this->id,
            'description'=>$this->description,
            'logo'=>$this->logo,
            'servicecategories'=> Servicecategories::collection($this->servicecategories->sortBy('ordernumber')),
             
         ];
    }
}
