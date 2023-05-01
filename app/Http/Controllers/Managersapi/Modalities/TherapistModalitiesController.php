<?php

namespace App\Http\Controllers\Managersapi\Modalities;

use App\ManagerSpeciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResources\v2\ManagerSpecialitiesResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class TherapistModalitiesController extends Controller
{
      public function getAllModalities()
    {
        $AllSpecialities=ManagerSpeciality::all();
        return response()->json(["data"=>ManagerSpecialitiesResource::collection($AllSpecialities),"status"=>true],200); 
    }

    public function getTherapistModaliies()
    {
    	$manager=Auth::user();
    	 $AllSpecialities=$manager->load('managerspecialities');
    	 $specialityCodes= $AllSpecialities->managerspecialities->pluck('id');
    	 return response()->json(['data'=>$specialityCodes,"status"=>true],200);
    }

  
  	public function updateModalities(Request $request)
  	{
       $request->validate([
            'modalities' => 'required|string|min:1',
            'other'=>'sometimes|string|nullable|min:3'
            
        ]);
$manager=Auth::user();
          
      if(!empty(request('modalities')))
    {
        $modalitiesId=explode(',', request('modalities'));
       $manager->managerspecialities()->sync($modalitiesId);
    
      }
      
$specialityCodes=$manager->managerspecialities->pluck('id');
      return response()->json(['data'=>$specialityCodes,"status"=>true],200);

  	}
}
