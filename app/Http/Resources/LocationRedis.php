<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationType;
use App\Http\Resources\Service;
use App\Http\Resources\Timings;
use App\Http\Resources\Employee;
//use App\Http\Resources\DayScheduleRedis;
use App\Http\Resources\Transactions;
class LocationRedis extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        //do not change or you will mess up the upload process to redis********

        return [
               "id"=>$this->id,
               "name"=>$this->name,
               "address"=>$this->address,
               "phone"=>$this->phone,
               "postalcode"=>$this->postalcode,
               "city"=>$this->city,
               "province"=>$this->province,
               "logo"=>$this->logo,
               "lat"=>$this->lat,
               "long"=>$this->long,
               "features"=>$this->features,
               'locale'=>$this->locale,
               'notifywho'=>$this->notifywho,
               'raiting'=>is_null($this->avgReviews($this->id)[0]->avgreview) ?$this->googleraiting:$this->avgReviews($this->id)[0]->avgreview,
               'ratingcount'=>is_null($this->avgReviews($this->id)[0]->avgreview) ?$this->number_reviews:$this->avgReviews($this->id)[0]->number_reviews,
               'ratingfrom'=>is_null($this->avgReviews($this->id)[0]->avgreview) ?"Google Ratings":"Instawalkin Ratings",
               "hours"=>$this->hours,
               "cashonly"=>$this->cashonly,
               "variedprices"=>$this->variedprices,
               "locationtypes"=>   LocationType::collection($this->locationtypes),
               "services"=> Service::collection($this->services),
               "employees"=>Employee::collection($this->employees),
               //"dayschedule"=>DayScheduleRedis::collection($this->dayschedule),
                "timings"=>  Timings::collection($this->timings),
                "lastvisit"=>$this->getlasttransactions->first()
                

        ];
    }
}
