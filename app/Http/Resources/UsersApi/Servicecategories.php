<?php

namespace App\Http\Resources\UsersApi;

use Illuminate\Http\Resources\Json\JsonResource;

class Servicecategories extends JsonResource
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
            'description'=>$this->description,
            'smalldescription'=>$this->smalldescription,
            'ordernumber'=>$this->ordernumber,
            'price'=>$this->instaprices
         ];
    }
}
