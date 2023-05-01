<?php

namespace App\Http\Controllers;

use App\ManagerNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ManagerNotifications as ManagerNotificationsResources;
class ManagerNotificationsController extends Controller
{

    public function __construct()
    {
        
       $this->middleware('auth:webmanager');

        
    }

    protected function guard()
{
    return Auth::guard('webmanager');
}

protected function validator(array $data)
    {
          
          
       $validator=Validator::make($data, [
            'desktop'=>'required',
            'desktopsound'=>'required',
            'web'=>'required',
            'websound'=>'required'
            ]);
          
     return $validator; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('managers.settings.notificationsettings');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ManagerNotifications  $managerNotifications
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //

       return new ManagerNotificationsResources(Auth::user()->managernotifications);
        //return response()->json(["managernotifications"=>Auth::user()->managernotifications]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManagerNotifications  $managerNotifications
     * @return \Illuminate\Http\Response
     */
    public function edit(ManagerNotifications $managerNotifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManagerNotifications  $managerNotifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManagerNotifications $managerNotifications)
    {
       
    $validator =$this->validator($request->all());
    if ($validator->fails())
        {
      return response()->json(['error'=>true,'message'=>$validator->messages(),'code'=>'400'],400);
    
         }

         
       $managernotification= ManagerNotifications::where('manager_id', Auth::id())->Update([

            'desktop'=>(bool) request('desktop'),
            'desktopsound'=>(bool)request('desktopsound'),
            'web'=>(bool)request('web'),
            'websound'=>(bool)request('websound')
            
            ]);
           
       return new ManagerNotificationsResources(Auth::user()->managernotifications);
        //return response()->json(['error'=>'false','managernotifications'=>$managernotifications,'code'=>'200'],200);
    }


    public function toggleSwitchToPhone(ManagerNotifications $managerNotifications)
    {
    $managernotification= ManagerNotifications::where('manager_id', Auth::id())->Update([

            'switchtophone'=>(bool) request('switchtophone'),
            
            ]);
           

           //fire an event to update sockets
       return new ManagerNotificationsResources(Auth::user()->managernotifications);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManagerNotifications  $managerNotifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManagerNotifications $managerNotifications)
    {
        //
    }
}
