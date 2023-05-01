<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstapriceResource extends JsonResource
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
            'id'=>$this->servicecategories->id,
            'description'=>$this->servicecategories->description,
            'ordernumber'=>$this->servicecategories->ordernumber,
            'price'=>$this->price,
            'price_id'=>$this->id
         ];
    }
}
