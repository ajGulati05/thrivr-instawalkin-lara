<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Resources\CommonResources\ProjectResource;
class ProjectPricingController extends Controller
{
    //

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManagerSpeciality  $managerSpeciality
     * @return \Illuminate\Http\Response
     */
    public function getAllProjectsAndPricing()
    {
        $projectPricing=Project::with('activeprojectpricing.calculatetax')->get();
        return ProjectResource::collection($projectPricing)->keyBy('id'); 
    }
}
