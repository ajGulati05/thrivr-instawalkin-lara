<?php

namespace App\Http\Controllers;

use App\CTARecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CTARecordController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   $validatedData = Validator::make($request->all(), [
               'email' => 'required|min:2',
               'type'=>'max:1'
    ]);


 if ($validatedData->fails()) {
                   return response()->json(["message"=> "The given data was invalid.",'errors'=>$validatedData->errors(),'status'=>false],422);
        }
   $type=null;
   $source='webapp';
   if($request->has('type'))
   {
    $type=request('type');
   }

     if($request->has('source'))
   {
    $source=request('source');
   }
          $contactForm = CTARecord::Create([

               'email' => request('email'),
               'type'=>$type,
               'source'=>$source

          ]);

          return response()->json(["message"=>"Your request has been receieved. One of our representatives will contact you within 24 hours.","status"=>true],200);
        
     }

   
}
