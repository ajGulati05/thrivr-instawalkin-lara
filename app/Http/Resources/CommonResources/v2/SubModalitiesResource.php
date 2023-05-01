<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonResources\v2\SubModalitiesPricing;

class SubModalitiesResource extends JsonResource
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
            "description" => $this->description,
            "minutes" => $this->minutes,
            "pricing" => new SubModalitiesPricing($this->subModalitiesPricings()->first())
        ];
    }
}
