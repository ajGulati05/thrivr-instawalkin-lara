<?php

namespace App\Http\Controllers\Usersapi;

use App\ManagerSpeciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerSpecialitiesController extends Controller
{
      public function getAllSpecialities()
    {
        $AllSpecialities=ManagerSpeciality::all();
        return $AllSpecialities; 
    }
}
