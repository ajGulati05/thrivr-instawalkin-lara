<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class PaymentTypeResource extends JsonResource
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
            'code' => $this->code,
            'description'=>$this->description,
            'active'=>true

           
        ];
    }
}
