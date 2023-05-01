<?php

namespace App\Http\Controllers\Usersapi\v2;


use App\Http\Controllers\Controller;

use App\Project;
use App\Manager;
use App\Http\Traits\v2\AvailabilityTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UsersApi\v2\TherapistResource;
use App\Http\Resources\UsersApi\v2\PracticeResource;
use App\RmtTeam;
use App\LaunchedCities;
use Illuminate\Http\Request;
class AvailabilityController extends Controller
{   

use AvailabilityTrait;


//this function returns time slots for all therapists

 public function index($project_id,$startDateTime,$timeZone,$lattitude,$longitude)
    {   
        $timeZone=str_replace('_','/',$timeZone);
    
     $project = Project::with(['activeAllProductManagers.manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                },'activeAllProductManagers.manager_specialities','activeAllProductManagers.availabilityConstraint',
            'activeListingManagers.manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                },'activeListingManagers.manager_specialities','activeListingManagers.availabilityConstraint'])->where('id', $project_id)->first();


   return response()->json(["data"=>$this->getMultipleTherapistsTimeSlot($project,$startDateTime,$timeZone,$lattitude,$longitude),"status"=>true], 200);
        

    }


//this function returns time slots for a single therapist
    public function slots(Manager $manager,Project $project,$startDateTime,$includeProfile, Request $request){
        //TODO add check if project works
      $lattitude=request('latitude');
      $longitude=request('longitude');
      $launchedCity=LaunchedCities::where('city_name','Saskatoon')->first();
      $lattitude=$launchedCity->latitude;
       $longitude=$launchedCity->longitude;
      if(!$manager->projects->contains($project->id))
      {
        response()->json(['error'=>'The therapist does not have a massage for that duration','status'=>false],200);
      }
         $managerWith=$manager->load(['manager_profiles' => function ($q) use ($lattitude,$longitude) {
               $q->getdistance($lattitude, $longitude);
                }]);
   

         $profileSlots=$this->getSingleTherapistsTimeSlot($managerWith,$project,$startDateTime,$manager->timezone,$includeProfile,null);
         $openDates=null;//$this->getNextOpenDate($managerWith,$project,$startDateTime,$manager->timezone);
   
        return response()->json(["data"=>["profileSlotsData"=>$profileSlots,"openDateData"=>$openDates],"status"=>true], 200);
    }



//this function returns time slots for a team of therapists

 public function teamSlots(   $launchedCity,RmtTeam $rmtTeam,$project_id,$startDateTime)
    {   
      
        $launchedCity=LaunchedCities::where('city_name',$launchedCity)->firstOrFail();

    
    $teamManagers=$rmtTeam->activeManagers->pluck('id');
    
  $lattitude=$launchedCity->latitude;
  $longitude=$launchedCity->longitude;
  $timeZone=$launchedCity->timezone;
   
     $project = Project::with(['activeAllProductManagers'=>function($q) use ($teamManagers){
        $q->whereIn('managers.id',$teamManagers);
     },'activeAllProductManagers.manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                },'activeAllProductManagers.manager_specialities','activeAllProductManagers.availabilityConstraint','activeListingManagers'=>function($q) use ($teamManagers){
        $q->whereIn('managers.id',$teamManagers);
     },
            'activeListingManagers.manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                },'activeListingManagers.manager_specialities','activeListingManagers.availabilityConstraint'])->where('id', $project_id)->first();

   return response()->json(["data"=>$this->getMultipleTherapistsTimeSlot($project,$startDateTime,$timeZone,$lattitude,$longitude),"practice_info"=>new PracticeResource($rmtTeam),"status"=>true], 200);
        

    }



//this function returns time slots for a team of therapists

 public function citySlots( $launchedCity,$project_id,$startDateTime)
    {   
      
        $launchedCity=LaunchedCities::where('city_name',$launchedCity)->firstOrFail();

Log::debug($launchedCity);
    
  $lattitude=$launchedCity->latitude;
  $longitude=$launchedCity->longitude;
  $timeZone=$launchedCity->timezone;
   
    $project = Project::with(['activeAllProductManagers.manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                },'activeAllProductManagers.manager_specialities','activeAllProductManagers.availabilityConstraint',
            'activeListingManagers.manager_profiles' => function ($q) use ($lattitude, $longitude) {
               $q->getdistance($lattitude, $longitude);
                },'activeListingManagers.manager_specialities','activeListingManagers.availabilityConstraint'])->where('id', $project_id)->first();


   return response()->json(["data"=>$this->getMultipleTherapistsTimeSlot($project,$startDateTime,$timeZone,$lattitude,$longitude),"status"=>true], 200);


        

    }
 



}