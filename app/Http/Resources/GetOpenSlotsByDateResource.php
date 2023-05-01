<?php

namespace App\Http\Resources;

use App\Http\Requests\GetTimekitOpenSlotsByDateRequest;
use App\Http\Traits\TimekitTrait;
use App\Manager;
use App\ManagerProfile;
use App\Project;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class GetOpenSlotsByDateResource extends JsonResource
{
    use TimekitTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

         return [
                "availabilities" => [],
            ];
          
        $startDateTime = $request->startDateTime;
        $endDateTime = $request->endDateTime;

        $project_id = $request->project_id;
        $address = $request->address;
        $manager_speciality_code = $request->manager_speciality_code;
        $project = Project::where('id', $project_id)->first();
        $timekit_project_id = $project->timekit_project_id;

        $project_length = $project->length;
        //this is for parsing the time
        preg_match_all('!\d+!', $project->length, $timeString);

        $startCarbon = new Carbon($startDateTime, 'America/Regina');
        $todayCarbon=Carbon::now('America/Regina');
        $minute=$todayCarbon->minute;
        $rounded_minute=round($todayCarbon->minute / 15) * 15;
        $todayCarbon=Carbon::now('America/Regina')->minutes($rounded_minute);
         Log::debug("startcarbin"); 
        Log::debug($startCarbon);
        Log::debug($todayCarbon); //look at the timezone for the area

        if ($startCarbon->toDateString()==$todayCarbon->toDateString()) {
            # code...
           $startCarbon=$todayCarbon->addHours(1);
        }
        $startString = $startCarbon->toAtomString();
        Log::debug("startcarbin"); 
        Log::debug($startString);
        $endCarbon = new Carbon($endDateTime, 'America/Regina');//look at the timezone for the area
        $endString = $endCarbon->toAtomString();
        $lattitude = $request->lattitude;
        $longitude = $request->longitude;
   
        if (empty($products)) {
            Log::debug("IS EMPTY");
        }

      
        $managers=Manager::whereHas('projects',function($query) use($project_id)
           { $query->where('projects.id', $project_id);})->where('managers.status',1)->where('managers.product_code','=','A')->with(['manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                }, 'manager_specialities'])->get();
      


 $managers=$managers->filter(function ($therapists, $key) {


    return $therapists['manager_profiles']->distance<100;
        });
  Log::debug($managers);
        //HERE WE CREATE THE MANAGERS LIST
        if (count($managers) > 0) {

           

           
         
if (count($managers) > 0) {
            //we get the availability from timekit by a project_id

            $getTimekitOpenSlotsByDateRequest = new GetTimekitOpenSlotsByDateRequest();
            $getTimekitOpenSlotsByDateRequest->project_id = $timekit_project_id;
            $getTimekitOpenSlotsByDateRequest->timeslot_increments = '15 minutes';
            $getTimekitOpenSlotsByDateRequest->length = $project_length;
            //hard code at 15 minutes 

            // are we sending time in america regina or UTC what are we getting time back in?
            $constraintItemContent['start'] = $startString;
            $constraintItemContent['end'] = $endString;
            $constraintItemContent['timezone']='America/Regina';

            $constraintItem['allow_period'] = (object) $constraintItemContent;
            $constraintList = [
                $constraintItem
            ];
            $getTimekitOpenSlotsByDateRequest->constraints = $constraintList;
            $responseContraints = collect();

            //this needs to be in a for loop based on managers resource id    
          
            if (count($managers) > 0) {

                foreach ($managers as $resourceItem) {

                    $getTimekitOpenSlotsByDateRequest->resource_id = $resourceItem['timekit_resource_id'];
                    Log::debug("going on everything------------------------------" . $resourceItem['timekit_resource_id']);
                    $responseContraints->push($this->getTimekitOpenSlotsByDate($getTimekitOpenSlotsByDateRequest));
                }
            }
            Log::debug("RESPONSE CONSTRAINTS------------------------------");
            Log::debug($responseContraints);


            //HERE WE DO THE PARSING FOR THE RESPONSE UNIFYING THE MANAGERS LIST AND THE /CONSTRAINTS
            $count = 0;
            if (count($responseContraints) > 0) {
                $finalConstraintList = collect();
                foreach ($responseContraints as $responseItem) {

                    foreach ($responseItem['data'] as $constraintItem) {

                        $currentResourceList = $constraintItem['resources'];

                        foreach ($currentResourceList as $resourceItem) {

                            $start = $constraintItem['start'];

                            $currentResourceItem['timekit_resource_id'] = $resourceItem['id'];
                            $currentResourceItem['start'] = $constraintItem['start'];
                            $currentResourceItem['end'] = $constraintItem['end'];
                            $currentResourceItem['display_time'] = $this->getDisplayTime($start);
                            $currentResourceItem['part_of_day'] = $this->getPartOfDay($start);
                            $finalConstraintList->push($currentResourceItem);
                        }
                        Log::debug("FINAL CONSTRAINT RESULT");
                        Log::debug($finalConstraintList);
                    }
                }
            }

            //NOW THE MATCH OF BOTH ARRAYS
            $matchedConstraintList = $finalConstraintList->groupBy('timekit_resource_id');
            Log::debug("FINAL CONSTRAINT MATCH RESULT----------");
            Log::debug(json_encode($matchedConstraintList));

            $finalResult = collect();
            foreach ($managers as $managerItem) {
                Log::debug('ITEM MATCH000000000000000');
                Log::debug($managerItem);

                $currentMatch = array();
                $currentMatch['manager_id'] = $managerItem['id'];
                $currentMatch['timekit_resource_id'] = $managerItem['timekit_resource_id'];
                $currentMatch['manager_first_name'] = $managerItem['first_name'];
                $currentMatch['manager_last_name'] = $managerItem['last_name'];
                $currentMatch['gender'] = $managerItem['gender'];
                $currentMatch['tag_line'] = $managerItem->manager_profiles->tag_line;
                $currentMatch['parking'] = $managerItem->manager_profiles->parking;
                $currentMatch['profile_photo'] = 'https://instawalkin-images.s3.ca-central-1.amazonaws.com/'.$managerItem['profile_photo'];
                $currentMatch['direct_billing'] = false;//$managerItem['direct_billing'];
                $currentMatch['verified'] = true;//$managerItem['verified'];
                $currentMatch['manager_specialities'] = $managerItem['manager_specialities'];
               
                       Log::debug("CURRENT  Profile2------------------------------");
                $currentMatch['phone'] = $managerItem->manager_profiles->phone;
                   $currentMatch['distance'] = round($managerItem->manager_profiles->distance, 1) . " Km";
                   $currentMatch['address'] = $managerItem->manager_profiles->address;
                   $currentMatch['address_description'] = $managerItem->manager_profiles->address_description;
                    $currentMatch['parking_description'] = $managerItem->manager_profiles->parking_description;
                  $currentMatch['postal_code'] = $managerItem->manager_profiles->postal_code;
                    $currentMatch['city'] = $managerItem->manager_profiles->city;
                    $currentMatch['latitude'] = $managerItem->manager_profiles->latitude;
                    $currentMatch['longitude'] = $managerItem->manager_profiles->longitude;
          
                $avaList = collect();
                $matchedConstraintList->map(function ($item, $key) use ($managerItem, $avaList) {
                    Log::debug('CONSTRATINT FINAL -----------');

                    if ($key == $managerItem['timekit_resource_id']) {
                       

                        $avaList->push($item);
                    }
                });
               
                // Log::debug(json_encode($currentAvaConstraintList));
                // Log::debug($currentAvaConstraintList[$currentMatch['timekit_resource_id']]);
                
               
                $currentMatch['availability'] = $avaList;
         
                $finalResult->push($currentMatch);

            }

    $finalResult=$finalResult->sortByDesc(function ($therapists, $key) {
    return count($therapists['availability']);
        });

            return [
                "availabilities" => $finalResult->toArray()
            ];
       }
       else {
            return [
                "availabilities" => [],
            ];
        } 
    } else {
            return [
                "availabilities" => [],
            ];
        }
    }


    public function getDisplayTime($start)
    {
        //TO DO not working yet
        return Carbon::parse($start, 'America/Regina')->isoFormat('h:mm a');
    }



    public function getPartOfDay($start)
    {
        //TO DO not working yet
        $hour = Carbon::parse($start, 'America/Regina')->isoFormat('H');

        if ($hour < 12) {
            return 'MORNING';
        }
        if ($hour < 17) {
            return 'AFTERNOON';
        }
        return 'EVENING';
    }
}
