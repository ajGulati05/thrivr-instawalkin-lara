<?php

namespace App\Http\Resources\CommonResources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectPricingResource extends JsonResource
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
            "project_id" => $this->project_id,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "amount" => $this->amount,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "taxes" => $this->calculatetax->sum('taxpercent'),
            "taxlabel" => $this->concattitle(),
        

        ];
    }
}
