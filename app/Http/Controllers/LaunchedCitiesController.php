<?php

namespace App\Http\Controllers;

use App\LaunchedCities;
use Illuminate\Http\Request;

class LaunchedCitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $LaunchedCities=LaunchedCities::all();
           return response()->json(["data"=>$LaunchedCities,"status"=>true], 200);
  
    }

}
