<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HoldingTransactionsResource extends JsonResource
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
            'id'=>$this->id,
            'promocodes'=>$this->promocode,
            'promoamount'=>$this->promoamount,
            'datevalue'=>$this->servicedate,
            'starttime'=>$this->service_starttime,//uses servicecategorie id
            'endtime'=>$this->service_endtime,
            'corporatepercent'=>$this->corporatepercent,
            'corporatecode'=>$this->corporatecode,
            'servicecategories'=>$this->servicecategories->description,
            'distance'=>$this->distance,
            'discount_type'=>$this->discount_type,
            'credits'=>$this->creditamount,
            'serviceamount'=>$this->instaprices->price,
            'gender'=>$this->gender
        ];
    }
}
