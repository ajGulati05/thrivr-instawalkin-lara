<?php

namespace App\Http\Resources\UsersApi;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserProfiles; 
use Carbon\Carbon;
use Gabievi\Promocodes\Models\Promocodes;
class UserHistory extends JsonResource
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
            "order"=>$this->id,
            'created_at'=>Carbon::parse($this->created_at)->toFormattedDateString(),
            'time'=>Carbon::parse($this->created_at)->toDateTimeString(),
            'location'=>$this->newname?$this->newname:$this->locations->name,
            'service'=>$this->servicecategories->description,
            'serviceamount'=>$this->serviceamount,
            'address'=>$this->newaddress?$this->newaddress:$this->locations->address,
            'city'=>$this->newcity?$this->newcity:$this->locations->city,
            'postalcode'=>$this->newpostalcode?$this->newpostalcode:$this->locations->postalcode,
            'lattitude'=>$this->newlat?$this->newlat:$this->locations->lat,
            'longitude'=>$this->newlong?$this->newlong:$this->locations->long,
            'durationvalue'=>$this->durationvalue,
            'taxamount'=>$this->taxamount,
            'totalamount'=> +$this->taxamount + +$this->serviceamount + +$this->tipamount - +$this->coupon_amount_calc,
            'tipamount'=> +$this->tipamount,
            'coupon_percent'=> +$this->coupon_percent,
            'coupon_amount_calc'=> +$this->coupon_amount_calc,
            'coupon_amount_tax'=> +$this->coupon_amount_tax,
            'transactionclosed'=>$this->transactionclosed,
            'arrival_at'=>$this->arrival_at,
            'tipclosed'=>false,
            'promocode'=>optional($this->promocodehistorys)->promocode_id,
            'discount_type'=>$this->discount_type,
            'creditgiven'=>$this->credithistorys,
            'reviews'=>$this->reviews,
            'read'=>$this->read,
             'description'=>$this->newdescription?$this->newdescription:$this->locations->description,
             'allowtip'=>$this->newname?false:true,
             // a user was given credit for this comes from credithistorys
           


            // gotta change that to make tip close happen properly
             
         ];
    }
}
