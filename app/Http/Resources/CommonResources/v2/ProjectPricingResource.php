<?php

namespace App\Http\Resources\CommonResources\v2;

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

        $taxes=$this->calculatetax->sum('taxpercent')==0?0:($this->calculatetax->sum('taxpercent') / 100) *$this->amount;
        $taxes=number_format((float)$taxes, 2, '.', '');
        
        return [
            'id' => $this->id,
            "amount" => $this->amount,
            "taxes" => $taxes,
            "taxlabel" => $this->concattitle(),
            "total_amount"=>$taxes + $this->amount,
        ];
    }
}
