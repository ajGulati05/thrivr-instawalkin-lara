<?php

namespace App\Http\Controllers\Usersapi\v2;

use App\CartView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class CartViewController extends Controller
{
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Manager $manager)
    {


         $user = Auth::user();
        
    $validatedData = $request->validate([
        'future_massage_date'=>'required|date'
    ]);

     $user->cartviews()->create(['future_massage_date'=>request('future_massage_date'),'manager_id'=>$manager->id]);
        return response()->json(["status"=>true]);

    }

  
}
