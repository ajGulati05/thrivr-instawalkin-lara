<?php

namespace App\Http\Controllers\Usersapi\v2;

use App\ManagerSpeciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResources\v2\ManagerSpecialitiesResource;
class ManagerSpecialitiesController extends Controller
{
      public function index()
    {
        $AllSpecialities=ManagerSpeciality::all();
    
        return response()->json(['data'=>ManagerSpecialitiesResource::collection($AllSpecialities),'status'=>true],200);
    }
}
