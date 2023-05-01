<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Gender;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Employee as EmployeesResources;
class EmployeesController extends Controller
{


     public function __construct()
    {
        
       $this->middleware('auth:webmanager');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //fix the location 
         $employees=Employee::withTrashed()->where('location_id','=',auth()->id())->get();
         //dd($employees);
    return view('managers.employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $genders=Gender::all();
        return view('managers.employees.create',compact('genders'));
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
            'firstname'=>'required|min:2',
            'lastname'=>'required|min:2',
            'licenseno'=>'required|min:1',
            'genderid'=>'required:min:1|max:1'
            ]);
         
        Employee::Create([

            'firstname'=>request('firstname'),

            'lastname'=>request('lastname'),
            'licenseno'=>request('licenseno'),
            'gender_id'=>request('genderid'),
            'manager_id'=>auth()->id()

            ]);
        if(request('btn')=='create' ) {
        return redirect()->route('employees.index');}
        elseif(request('btn')=='savecreate')
        {
            return redirect()->route('employees.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(employee $employee)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(employee $employee)
    {
        //
    }
}
