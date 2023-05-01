<?php

namespace App\Http\Resources\CommonResources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonResources\ProjectPricingResource;

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
            "timekit_project_id" => $this->timekit_project_id,
            "slug" => $this->slug,
            "name" => $this->name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "length" => $this->length,
            "buffer" => $this->buffer,
            "default" => $this->default,
            "mobile_name" => $this->mobile_name,
            "project_pricings" => new ProjectPricingResource($this->activeprojectpricing->first())
        ];
    }
}
