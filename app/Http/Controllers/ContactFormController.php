<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactForm;
use App\Notifications\ContactUsReply;
use App;
use Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ContactFormController extends Controller
{
    
  public function create(){
  
  }




     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
      
   
$validatedData = Validator::make($request->all(),[
      'name' => 'required|min:2',
               'email' => 'required|email',
               'comment' => 'required|min:2'
    ]);


 if ($validatedData->fails()) {
                   return response()->json(["message"=> "The given data was invalid.",'errors'=>$validatedData->errors(),'status'=>false],422);
        }
          $contactForm = ContactForm::Create([

               'name' => request('name'),
               'phone' => '13062625152',
               'email' => request('email'),
               'comment' => request('comment')

          ]);
          $contactForm->notify(new ContactUsReply($contactForm));
          return response()->json(["message"=>"Your request has been receieved. One of our representatives will contact you within 24 hours.","status"=>true],200);
        
     }


   
}
