<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\v2\TimekitTraitV2;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Notification;
use App\Notifications\RequestDemoNotification;
use App\DemoRequest;
class DemoController extends Controller
{
    use TimekitTraitV2;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($timezone,$demodate)
    {       $timezone=str_replace('_','/',$timezone);
            $demoFrom=Carbon::parse($demodate,$timezone);
            $todate=Carbon::parse($demodate,$timezone)->add(1,"day");
          return response()->json(["data"=>$this->getTimekitOpenSlotsByProject($timezone,$demoFrom,$todate),"status"=>true], 200);
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request$request,$timezone)
    {       $timezone=str_replace('_','/',$timezone);
     $request->validate([
        'name'=>'required|string',
        'email'=>'required|string|email',
        'phone'=>'sometimes|string|min:11|max:17|nullable',

    ]);
  $toRemove = array(" ", "(", ")", "-");
        $toReplaceWith   = array("", "", "","");
        $phone = $newphrase = str_replace($toRemove, $toReplaceWith, request('phone'));
        $demorequest= DemoRequest::create([

        'name'=>request('name'),
        'email'=>request('email'),
        'phone'=>$phone,
        'timekit_resource_id'=>request('resource_id'),
         'demo_date'=>Carbon::parse(request('start'))
     ]);

               $demorequest->notify(new RequestDemoNotification($demorequest));
     //TODO add booking to TimekitTraitV2
     //if approved add it to our DB 
     // send emails out
          return response()->json(["message"=>"Your demo has been booked, you will be getting a confirmation email shortly","status"=>true], 200);
    }


  
}
