<?php

namespace App\Http\Controllers\Managersapi\License;

use App\ManagerSpeciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TherapistApi\TherapistLicenseResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class TherapistLicenseContoller extends Controller
{
      public function list()
    {
        $manager=Auth::user();
         $licenses=$manager->manager_licenses()->latest()->firstOrFail();
        
        return response()->json(["data"=>new TherapistLicenseResource($licenses),"status"=>true],200); 
    }

       public function create(Request $request)
    {
        $manager=Auth::user();
          $request->validate([
          'license' => 'required|string',
    ]);
         
         $manager->manager_licenses()->create(['license_number'=>request('license')]);
         $licenses=$manager->manager_licenses()->latest()->first();
        return response()->json(["data"=>new TherapistLicenseResource($licenses),"status"=>true],200); 
    }
   
}
