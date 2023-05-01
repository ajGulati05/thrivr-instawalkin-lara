<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonResources\v2\ProjectPricingResource;

class ProjectResource extends JsonResource
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
            'id' => $this->id,
            "description" => $this->description,
            "slug" => $this->slug,
            "name" => $this->name,
            "default" => $this->default,
            "mobile_name" => $this->mobile_name,
            "pricing" => new ProjectPricingResource($this->activeprojectpricing->first())
        ];
    }
}
