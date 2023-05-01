<?php

namespace App\Http\Controllers\Managersapi;

use App\ManagerSpeciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\Http\Resources\CommonResources\v2\ProjectResource;
use App\Http\Resources\TherapistApi\TherapistProjectResource;
class TherapistProjectsController extends Controller
{
      public function getAllProjects()
    {
      $projectPricing=Project::with('activeprojectpricing.calculatetax')->get();
 
        return response()->json(['data'=>ProjectResource::collection($projectPricing),'status'=>true],200);
    }

 public function list(){
            $projectPricing=Auth::user()->load('projects.activeprojectpricing.calculatetax');

            return response()->json(['data'=>$projectPricing->projects->pluck('id'),'status'=>true],200);
    }



    public function update(Request $request)
  	{
       $request->validate([
            'durations' => 'required|string|min:1',
            
            
        ]);
$manager=Auth::user();
          
      if(!empty(request('durations')))
    {
        $projectsID=explode(',', request('durations'));
       $manager->projects()->sync($projectsID);
    
      }
      
$projects=$manager->projects;
    return response()->json(['data'=>$projects->pluck('id'),'status'=>true],200);

  	}
}
