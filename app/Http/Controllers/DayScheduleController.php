<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DaySchedule;
use App\Manager;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DaySchedule as DayScheduleResources;
use App\Events\NewDaySchedule;
use App\Events\DeleteDaySchedule;

class DayScheduleController extends Controller
{
       public function __construct()
    {
        
       $this->middleware('auth:webmanager');
        
    }

       public function store(Request $request)
    {
        $this->validate($request, [
            'scheduledtime' => 'required',

        ]);
        
         $manager=Auth::id();
         $managers=Manager::with('locations')->find($manager);
 $dayschedule=DaySchedule::create([ 'scheduledtime' => request('scheduledtime'),'employee_id'=>request('employee_id'),
        'location_id'=>$managers->locations->id,'service_id'=>request('service_id') ]);

        event(new NewDaySchedule(Auth::user()->email,$dayschedule));
         return new DayScheduleResources($dayschedule);
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
     //  $employees=Employee::withTrashed()->where('location_id','=',auth()->id())->get();
         //dd($employees);
    return view('managers.dayschedule.index');
    }


      public function restoremodel($id)
    {
       
        DaySchedule::withTrashed()->find($id)->restore();
        return redirect()->route('admin.main');
        
         
    }    
    public function destroy(DaySchedule $dayschedule)
    {   
        event(new DeleteDaySchedule(Auth::user()->email,request('id')));
        DaySchedule::find(request('id'))->delete();
        return response()->json(['error'=>'false','status'=>'201','code'=>'201'],201); 
    }
}
