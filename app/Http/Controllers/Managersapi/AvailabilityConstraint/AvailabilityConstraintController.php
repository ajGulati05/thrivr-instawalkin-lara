<?php

namespace App\Http\Controllers\Managersapi\AvailabilityConstraint;

use App\AvailabilityConstraint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TherapistApi\AvailabilityConstraintResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\v2\TimekitTraitV2;
use App\Http\Requests\SetResourceTimeConstraintsRequest;
class AvailabilityConstraintController extends Controller
{
  
   use TimekitTraitV2;
    public function getAvailabilityConstraint()
    {
      $manager=Auth::user();
      $availabilityConstraints = $this->getResourceTimeConstraintsTimekitTrait($manager->timekit_resource_id); //should it be just a record?
      $bufferConstraints=$manager->load('availabilityConstraint');
      $dataKeyArray=$availabilityConstraints['data'];
    $mainConstraints=[];
if (array_key_exists('availability_constraints',$dataKeyArray) ) 
    {    
      $mainConstraints=$dataKeyArray['availability_constraints'];
       }
   

       return response()->json(["data"=>["availabilityConstraints"=>$mainConstraints,"buffer"=> new AvailabilityConstraintResource($bufferConstraints->availabilityConstraint)],"status"=>true],200);
       //$specialityCodes= $AllSpecialities->managerspecialities->pluck('code');
       //return response()->json(['data'=>["therapist_modalities"=>$specialityCodes],"status"=>true],200);
    }

  
    public function updateAvailabilityConstraint(Request $request)
    {
     
     
         $request->validate([
    
             'availability_constraints' => 'required',
            'buffer' => 'required|string',
            
            
        ]);

       $manager = Auth::user();
        //We create a timekit resource
       $setResourceTimeConstraintsRequest = new SetResourceTimeConstraintsRequest();
       $setResourceTimeConstraintsRequest->timekit_resource_id = $manager->timekit_resource_id;
       $setResourceTimeConstraintsRequest->availability_constraints = request('availability_constraints');
       $manager->availabilityConstraint->update(['end_buffer'=>request('buffer')]);
        //$setResourceTimeConstraintsRequest->availability_constraints->allow_period->timezone = 'America\Regina';


      $response= $this->setResourceTimeConstraintsTimekitTrait($setResourceTimeConstraintsRequest);
        //Here we get the id of the timekit resource

        return response()->json([
          'message'=>"Your availability has been updated",
            'data' => ["availabilityConstraints"=>$response,"buffers"=> new AvailabilityConstraintResource($manager->availabilityConstraint)],
            'status'=>true
        ]);
    }
}



