<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Manager;
use App\Http\Requests\ServicesForm;
use Carbon\Carbon;
use App\Servicecategory;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    //

    public function __construct()
    {
        
        $this->middleware('auth:webmanager');
      
    }

    public function index()
    {
       
	//top one returns json

	//this one returns view 
    $services=Service::with('servicecategory','taxes')->status()->where('location_id','=',Manager::find(Auth::id())->locations->id)->get();

    

    return view('managers.services.index',compact('services'));

    }


public function indexLocationServices()
    {
       
    //top one returns json

    //this one returns view 
    $services=Service::with('servicecategory','taxes')->status()->where('location_id','=',Manager::find(Auth::id())->locations->id)->get();

    

    return view('managers.services.index',compact('services'));

    }
    public function show(Service $service)
    {
    
   // 

   return view('services.show',compact('service'));
    }

    public function create()
    {

        
        $servicecategories=Servicecategory::where('locationtype_id','=',Manager::where('id','=',auth('webmanager')->user()->id)->first()->locations->locationtype_id)->get();
       
        return view('services.create',compact('servicecategories'));
    }


    public function store()
    {

        $this->validate(request(),[
            'servicecategory'=>'required',
            'amount'=>'required|min:1'
            ]);
        Service::Create([

            'servicecategory_id'=>request('servicecategory'),

            'amount'=>request('amount'),

            'manager_id'=>auth()->id()

            ]);
        if(request('btn')=='create' ) {
        return redirect()->route('services.index');}
        elseif(request('btn')=='savecreate')
        {
            return redirect()->route('services.create');
        }
    }


  
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Service $service)
    {

        //dd(Carbon::now());

      $this->isUsers($service->manager_id);
              //
       // dd(request('description'));
        if(request('btn')=='delete' ) {
            $service->status=true;
            $service->end_date= Carbon::now();
             $service->save();
        return redirect()->route('services.index');}
       
        elseif(request('btn')=='save')
            {
                $service->description=request('description');
                 $service->save();
            return redirect()->route('services.index');
        }


        
        }
    

      
      
   

  

   
}
