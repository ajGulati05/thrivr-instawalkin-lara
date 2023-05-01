<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class SubModalitiesPricing extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

            $taxes=0.05 *$this->price;
            $taxes=number_format((float)$taxes, 2, '.', '');
        return [
            'id' => $this->id,
            "price" => $this->price,
            "taxes"=>$taxes,
            "total"=>$taxes+$this->price

           
        ];
    }
}
