<?php

namespace App\Http\Traits\v2;

use App\Http\Traits\v2\TimekitTraitV2;
use App\Http\Requests\GetTimekitOpenSlotsByDateRequest;
use Carbon\Carbon;
use App\Manager;
use App\Http\Resources\UsersApi\v2\AvailabilityResource;
use Illuminate\Support\Facades\Log;
use App\Project;
use Illuminate\Http\Request;
use App;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\UsersApi\v2\TherapistResource;
use Illuminate\Support\Collection;
use Exception; 
 use App\Helpers\CustomStringHelper;
trait AvailabilityTrait
{
    use TimekitTraitV2;

public function getTimeSlotsForAvailability(){
    
}

public function getMultipleTherapistsTimeSlot($project,$startDateTime,$timeZone,$lattitude,$longitude){
 $timekit_project_id = $project->timekit_project_id;
        $project_length = $project->length;
        $project_buffer=$project->buffer; 
        //TODO add buffer time based on therapist to the project length 
        //currently we only have a buffer period based on project
 

  
         $endString=$this->getEndString($startDateTime,$timeZone);

        $managers=$project->activeAllProductManagers;

 
        //TODO find a better way to do this
         $managers=$managers->filter(function ($therapists, $key) {
      
                    return $therapists['manager_profiles']->distance<100;
        });
             $listingManagers=$project->activeListingManagers->filter(function ($therapists, $key) {
                 
                    return $therapists['manager_profiles']->distance<100;
        });

                    
$available_therapists=null;
$listing_therapists=null;
$daysAvailable=collect();
$firstDayAvailable=collect();
$availablility= ["daysAvailable"=>$daysAvailable,"askedDateAvailable"=>false,"timeslots"=>$firstDayAvailable->all()];


$startString=Carbon::now()->toAtomString();
if (count($managers) > 0) {
            //we get the availability from timekit by a project_id

            $responseContraints = collect();
            $poolRequests=collect();
 //$time_start = microtime(true);
            foreach ($managers as $resourceItem) {

                 
                   $startString=$this->getStartString($startDateTime,$timeZone,$resourceItem->availabilityConstraint->start_buffer);
                 
                   

                   $createdRequest= $this->createRequest($resourceItem->profiles,$timekit_project_id,$project_buffer,$project_length,$startString,$endString,$timeZone,$resourceItem['timekit_resource_id'],$resourceItem->availabilityConstraint->end_buffer);
        


                    $poolRequests->push($this->getTimekitOpenSlotsByDate($createdRequest,$resourceItem->profiles->ics_url));
              
                
                }
                $x=$this->sendPoolRequestToTimeKit($poolRequests);

  
        $finalConstraintList =$this->sortAvailabilityByTimekitId($x,$timeZone,$startString);
         

             $matchedConstraintList = $finalConstraintList->groupBy('resource_id');
             
// echo 'Sequential execution time in seconds: ' . (microtime(true) - $time_start);
 
      
              $finalResult = collect();

            foreach ($managers as $managerItem) {
              

                $currentManagerItem = $managerItem;
             
          
                $avaList = collect();
                $matchedConstraintList->map(function ($item, $key) use ($managerItem, $avaList) {
                 
                    if ($key == $managerItem['timekit_resource_id']) {
                       

                        $avaList->push($item[0]);
                    }
                });

                if($avaList->isNotEmpty()){
                         $currentManagerItem['availability'] = $avaList[0];
                }
              else{
                $currentManagerItem['availability'] = $availablility;
              }
               
               
                $finalResult->push($currentManagerItem);

            }



  $available_therapists=TherapistResource::collection($finalResult);

        //    return response()->json(["data"=>$finalResult->toArray(),"status"=>true],200);
          
        }
if($listingManagers->isNotEmpty())
{
    $listing_therapists=TherapistResource::collection($listingManagers);
}
return   ["available_therapists"=>$available_therapists,"listing_therapists"=>$listing_therapists];
}







public function getSingleTherapistsTimeSlot($manager,$project,$startDateTime,$timeZone,$includeProfile,$endDateTime=null){


if($includeProfile==1 && $manager->isListingManager()){
    return  new TherapistResource($manager);
}

if($manager->isListingManager()){
    return [];
}
$daysAvailable=collect();
$firstDayAvailable=collect();

$availablility= ["daysAvailable"=>$daysAvailable,"askedDateAvailable"=>false,"timeslots"=>$firstDayAvailable->all()];

 $timekit_project_id = $project->timekit_project_id;
$project_length = $project->length;
$project_buffer=$project->buffer; 
$startString=$this->getStartString($startDateTime,$timeZone,$manager->availabilityConstraint->start_buffer);

$endString=$this->getEndString($startDateTime,$timeZone);
$responseContraints = collect();
$createdRequest= $this->createRequest($manager->profiles,$timekit_project_id,$project_buffer,$project_length,$startString,$endString,$timeZone,$manager->timekit_resource_id,
$manager->availabilityConstraint->end_buffer);

$responseContraints->push($this->getTimekitOpenSlotsByDateWrapper($createdRequest,$manager->profiles->ics_url));

 try {

if(sizeOf($responseContraints[0]["data"])>0)
{
    $availablility=$this->sortAvailabilityByTimekitId($responseContraints,$timeZone,$startString)[0]; 

}
        // Validate the value...
    } catch (\Exception $e) {
     Log::critical("Not available ". $manager->id);
    }


 if($includeProfile==1){
              
                $manager['availability'] = $availablility;
              $finalResult=collect();
              $finalResult->push($manager);
              
         return  TherapistResource::collection($finalResult);
    }

return $availablility;
}




//
public function createRequest($profiles,$timekit_project_id,$project_buffer,$project_length,$startString,$endString,$timeZone,$timekit_resource_id,$end_buffer ="15 minutes"){
          
            //$constraintItemContent['start'] = $startString;
            //$constraintItemContent['end'] = "$endString";    
            $constraintItemContent['timezone']=$timeZone;
           // $constraintItem['allow_period'] = (object) $constraintItemContent;
      //      $constraintList = [
        //        $constraintItem
          //  ];

            if($profiles->add_buffer_to_duration){
            
             $project_length=$this->getAppointmentLength($project_length,$end_buffer);
             $end_buffer="0 minutes";
            }

        

            $getTimekitOpenSlotsByDateRequest=collect(["project_id" => $timekit_project_id,
            "timeslot_increments" =>  $project_buffer,

            "buffer" =>  $end_buffer,
            "length"=>$project_length,


            "resource_id"=>$timekit_resource_id,
          //  "constraints" => $constraintList,
            "from"=>$startString,
            "to"=>$endString]);
            return $getTimekitOpenSlotsByDateRequest->toArray();
}



public function sortAvailabilityByTimekitId($responseContraints,$timeZone,$startDate){
   


             $finalConstraintList = collect();
            if (count($responseContraints) > 0) {

              foreach ($responseContraints as $responseItem) {
               
                
                  $decodedTimekitData= collect($responseItem["data"]);


                  $groupByResourceID= $decodedTimekitData->groupBy(function ($item, $key) {
                          return  $item['resources'][0]['id'];
                    });
       

            foreach ($groupByResourceID as $key=>$resourceItem) {

                    $sortedTimes=$this->sortTimes($key,$resourceItem,$timeZone,$startDate);
                     $finalConstraintList->push($sortedTimes);
            }
         
                 
            }
         }    

     
            return $finalConstraintList;
}

//Get all timeslots for current day and then get all timeslots for next day
public function sortTimes($resourceId,$responseContraints,$timeZone,$startString){

Log::debug('sortTimes');

  $daysAvailable=collect();
  $askedDateAvailable=false;
  $timeslots=collect();
if (count($responseContraints) > 0) {
$startDate=Carbon::parse($startString)->format('Y-m-d');



$groupByStartDate= $responseContraints->groupBy(function ($item, $key) {
   
      return Carbon::parse($item['start'])->format('Y-m-d');
   

});


$daysAvailable= $groupByStartDate->keys();
$askedDateAvailable=$daysAvailable->contains(function ($item) use ($startDate) {


    return Carbon::parse($item)->format('Y-m-d')==$startDate;
});
$firstDayAvailable= $groupByStartDate->first();


$firstDayAvailable=$firstDayAvailable->map(function ($item) use($timeZone) {
     $start = $item['start'];
     $currentResourceItem['timekit_resource_id'] = $item['resources'][0]['id'];
     $currentResourceItem['start'] = $item['start'];
     $currentResourceItem['end'] = $item['end'];
     $currentResourceItem['display_time'] = $this->getDisplayTime($start,$timeZone);
     $currentResourceItem['part_of_day'] = $this->getPartOfDay($start,$timeZone);
     return $currentResourceItem;
});
}
 return ["resource_id"=>$resourceId,"daysAvailable"=>$daysAvailable,"askedDateAvailable"=>$askedDateAvailable,"timeslots"=>$firstDayAvailable->all()];
        

           
}





public function getDisplayTime($start,$timeZone)
    {
        //TO DO not working yet
        return Carbon::parse($start, $timeZone)->isoFormat('h:mm a');
    }


public function getStartString($startDateTime,$timeZone,$startBufferMinutes='60'){
//for some reason its adding one more day
    //User searches for a time, I get the date from the server so I take that time convert itto that timezone
          $startTime= new Carbon($startDateTime, $timeZone);
          $startCarbon = new Carbon($startDateTime, $timeZone);
          $todayCarbon=Carbon::now($timeZone);
          $minute=$todayCarbon->minute;
        
          $startBufferMinutes= preg_replace('/\D/','', $startBufferMinutes);
     
        // If startCarbon is today we use current time
        $rounded_minute=round($todayCarbon->minute / 15) * 15;
        $todayCarbon=Carbon::now($timeZone)->minutes($rounded_minute);
        $startCarbon=$startCarbon->minutes($rounded_minute);
        if ($startCarbon->toDateString()==$todayCarbon->toDateString()) {
            # code...
           $startCarbon=$todayCarbon->addMinutes($startBufferMinutes);
        }
          else{
        
        $startCarbon=$startCarbon->copy()->startOfDay();
        }
       


       if($startCarbon->gte($startTime->endOfDay()))
        {
            $startCarbon=$startTime->endOfDay()->subMinute();
        }


        return $startCarbon->toAtomString();

}

public function getEndString($startDateTime,$timeZone){
    $startCarbon = new Carbon($startDateTime, $timeZone);
    return $startCarbon->copy()->addWeeks(4)->toAtomString();
}
public function getPartOfDay($start,$timeZone)
    {
        //TO DO not working yet
        $hour = Carbon::parse($start, $timeZone)->isoFormat('H');

        if ($hour < 12) {
            return 'MORNING';
        }
        if ($hour < 17) {
            return 'AFTERNOON';
        }
        return 'EVENING';
    }

public function getAppointmentLength($length,$buffer){
 
   return CustomStringHelper::addBufferPlusMinutesString(CustomStringHelper::getFirstIntegerFromString($length),CustomStringHelper::getFirstIntegerFromString($buffer));
  


}

    
}
