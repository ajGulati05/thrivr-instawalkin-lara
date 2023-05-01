<?php

namespace App\Http\Controllers\Managersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\v2\TimekitTraitV2;
use App\Http\Requests\SetResourceTimeConstraintsRequest;
use App\AvailabilityConstraint;
use App\Manager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class TimekitController extends Controller
{

    use TimekitTraitV2;

    public function  setResourceTimeConstraints(Request $request)
    {
        $manager = Auth::user();
        $data = json_decode($request->getContent(), true);
     
        //We create a timekit resource
       $setResourceTimeConstraintsRequest = new SetResourceTimeConstraintsRequest();
       $setResourceTimeConstraintsRequest->timekit_resource_id = $manager->timekit_resource_id;
       $setResourceTimeConstraintsRequest->availability_constraints = $request->json('availability_constraints');
        //$setResourceTimeConstraintsRequest->availability_constraints->allow_period->timezone = 'America\Regina';


       $this->setResourceTimeConstraintsTimekitTrait($setResourceTimeConstraintsRequest);
        //Here we get the id of the timekit resource

        return response()->json([
            'message' => 'Availability Constraint Updated'
        ]);
    }


    public function  getResourceTimeConstraints()
    {
      
       $manager = Auth::user();
     
        $availabilityConstraints = $this->getResourceTimeConstraintsTimekitTrait($manager->timekit_resource_id); //should it be just a record?

       return $availabilityConstraints;
      
    }

}
