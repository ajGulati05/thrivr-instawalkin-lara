<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserProfiles; 
use Carbon\Carbon;
class Transactions extends JsonResource
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
            'user'=>optional($this->userprofiles)->firstname,
            'location'=>$this->locations->name,
            'service'=>$this->servicecategories->description,
            'altdescription'=>$this->services->altdescription,//uses servicecategorie id
            'serviceamount'=>$this->serviceamount,
            'taxamount'=>$this->taxamount,
            'tipamount'=>$this->tipamount,
            'total'=>$this->taxamount+$this->serviceamount,
            'instawalkinpromo'=>$this->coupon_amount_calc,
            'clientpaid'=>$this->discount_type=='P'? (+$this->serviceamount + +$this->taxamount)-$this->coupon_amount_calc:(+$this->serviceamount + +$this->taxamount),
            'responsecode'=>$this->serviceresponse->description,
            'created_at'=>Carbon::parse($this->created_at)->toFormattedDateString(),
            'employee_id'=>$this->employee_id,
            'employee_name'=>optional($this->employees)->firstname,
            'afterstatus'=>$this->afterstatus,
            'wrongamount'=>$this->wrongamount,
            'duration'=>$this->durationvalue,
            'arrival_at'=>Carbon::parse($this->arrival_at)->format('H:i'),
            'canedit'=>true,
            'holdingtransactions_id'=>$this->holdingtransactions_id,
            'newarrival_at'=>$this->arrival_at,
           
        ];
    }
}
