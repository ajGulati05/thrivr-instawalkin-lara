<?php

namespace App\Http\Controllers\Managersapi\Modalities;

use App\SubModalitie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResources\v2\SubModalitiesResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class TherapistSubModalitiesController extends Controller
{
      public function list()
    {
        $subModalities=SubModalitie::all();
   
        return response()->json(["data"=>SubModalitiesResource::collection($subModalities),"status"=>true],200); 
    }

    public function getTherapistSubModaliies()
    {
      $manager=Auth::user();
       $therapistSubModalities=$manager->load('submodalities');
       $specialityCodes= $therapistSubModalities->submodalities->pluck('code');
       return response()->json(['data'=>$specialityCodes,"status"=>true],200);
    }

  
    public function updateSubModalities(Request $request)
    {
       $request->validate([
            'submodalities' => 'sometimes|string|nullable',
           
            
        ]);
$manager=Auth::user();
          
      if(!empty(request('submodalities')))
    {
        $modalitiesId=explode(',', request('submodalities'));
       $manager->submodalities()->sync($modalitiesId);
    
      }

      else{
          $manager->submodalities()->detach();
      }
      
$submodalities=$manager->submodalities->pluck('code');
      return response()->json(['data'=>$submodalities,"status"=>true],200);

    }
}
