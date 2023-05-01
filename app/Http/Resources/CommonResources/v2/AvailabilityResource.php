<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class AvailabilityResource extends JsonResource
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
            'timekit_resource_id' => $this->timekit_resource_id,
           
        ];
    }
}
