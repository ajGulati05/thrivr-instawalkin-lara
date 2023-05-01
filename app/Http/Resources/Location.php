<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationType;
use App\Http\Resources\Service;
use App\Http\Resources\Timings;
use App\Http\Resources\Employee;
use App\Http\Resources\DaySchedule;
use App\Http\Resources\Transactions;
use App\Transactions as TransactionsModel;
class Location extends JsonResource
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
               'locale'=>$this->locale,
               'features'=>$this->features,
               'notifywho'=>$this->notifywho,
               'raiting'=>$this->googleraiting,
               "locationtypes"=>   LocationType::collection($this->locationtypes),
               "services"=> Service::collection($this->services),
               "employees"=>Employee::collection($this->employeesWithTrashed),
               "dayschedule"=>DaySchedule::collection($this->dayscheduleFuture),
               "timings"=>  Timings::collection($this->timings),
               "biweekly"=>TransactionsModel::managerHistoryWebBiWeekly($this->id)->keyBy('rowID'),
               "transactions"=>Transactions::collection($this->oldTransactionsInital)->keyBy('id'),
               "currenttransactions"=>Transactions::collection($this->currentTransactions)->keyBy('id'),
               

        ];
    }
}
