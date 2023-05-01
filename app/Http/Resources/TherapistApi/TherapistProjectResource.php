<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistProjectResource extends JsonResource
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
            "id"=>$this->id
         ];
    }
}
