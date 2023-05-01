<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PartnerForm;
use App\Events\BecomeAPartnerFormSubmit;
use App\Notifications\BecomeAPartnerStandardForward;
use App\Notifications\BecomeAPartnerStandardReply;
use App;
use Notification;

class PartnerFormController extends Controller
{
    //
     public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $employees=Employee::active()->where('manager_id','=',auth()->id())->get();
         //dd($employees);
    return view('managers.employees.index',compact('employees'));
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
    
        
         $this->validate(request(),[
            'businessname'=>'required|min:2',
            'contactname'=>'required|min:2',
            'contactphone'=>'required|min:1',
            'contactemail'=>'required|email',
            'city'=>'required|min:2'
            ]);
         
       $partnerForm= PartnerForm::Create([

            'businessname'=>request('businessname'),

            'contactname'=>request('contactname'),
            'contactphone'=>request('contactphone'),
            'contactemail'=>request('contactemail'),
            'city'=>request('city')

            ]);
         if (App::environment(['production'])) {
            Notification::route('mail',$partnerForm->contactemail)
            ->notify(new BecomeAPartnerStandardReply($partnerForm));
            
       }
       else{
            Notification::route('mail',config('app.ccemail'))
       ->notify(new BecomeAPartnerStandardReply($partnerForm));
        
       }

       Notification::route('mail',config('app.ccemail'))
       ->notify(new BecomeAPartnerStandardForward($partnerForm));
        
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerForm $partnerform)
    {
        //
        return ('xs');
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartnerForm $partnerform)
    {
        //
    }

  
}
