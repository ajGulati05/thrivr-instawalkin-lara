<?php


namespace App\Http\Controllers\Managersapi\AvailabilityConstraint;


use App\Http\Controllers\Controller;
use App\Project;
use App\Http\Traits\v2\AvailabilityTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersApi\v2\TherapistResource;
class AvailabilityController extends Controller
{   

use AvailabilityTrait;




    public function slots(Project $project,$startDateTime,$endDateTime){
        //TODO add check if project works
        $manager=Auth::user();
      if(!$manager->projects->contains($project->id))
      {
        response()->json(['error'=>'The therapist does not have a massage for that duration','status'=>false],200);
      }
         $managerWith=$manager->load('profiles');
         
   
        return response()->json(["data"=>$this->getSingleTherapistsTimeSlot($managerWith,$project,$startDateTime,$manager->timeZone,0,$endDateTime),"status"=>true], 200);
    }
}