<?php

namespace App\Http\Controllers;

use App\Endorsement;
use Illuminate\Http\Request;
use App\Http\Resources\CommonResources\v2\EndorsementResource;
class EndorsementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $endorsement=Endorsement::all();

        return response()->json(['data'=>EndorsementResource::collection($endorsement),'status'=>true],200);
    }

  
}
