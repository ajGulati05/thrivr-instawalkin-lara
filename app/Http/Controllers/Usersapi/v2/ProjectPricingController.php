<?php

namespace App\Http\Controllers\Usersapi\v2;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Resources\CommonResources\v2\ProjectResource;
use App\Http\Controllers\Controller;
use App\Manager;
class ProjectPricingController extends Controller
{
    //

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManagerSpeciality  $managerSpeciality
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectPricing=Project::with('activeprojectpricing.calculatetax')->get();
 
        return response()->json(['data'=>ProjectResource::collection($projectPricing),'status'=>true],200);

    }


    public function getIndividualProjects(Manager $manager){
            $projectPricing=$manager->load('projects.activeprojectpricing.calculatetax');
            return response()->json(['data'=>ProjectResource::collection($projectPricing->projects),'status'=>true],200);
    }
}
