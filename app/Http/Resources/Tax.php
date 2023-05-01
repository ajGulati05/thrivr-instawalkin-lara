<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tax extends JsonResource
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
            'taxcode'=>$this->taxcode,
            'taxpercent'=>$this->taxpercent,
            'end_date'=>$this->end_date
        ];
    }
}
