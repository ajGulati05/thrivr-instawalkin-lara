<?php

namespace App\Http\Controllers\Common;

use App\PaymentType;
use App\Http\Resources\CommonResources\v2\PaymentTypeResource;
use App\Http\Controllers\Controller;
class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return response()->json(['data'=> PaymentTypeResource::collection(PaymentType::where('active',true)->get()),'status'=>true]);
    }

 
}
