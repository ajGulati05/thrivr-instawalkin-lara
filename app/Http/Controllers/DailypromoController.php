<?php

namespace App\Http\Controllers;

use App\Dailypromo;
use App\Locationtype;
use Illuminate\Http\Request;
use Carbon\Carbon;
class DailypromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $dailypromos=Dailypromo::get();
         return view('admin.promocodes.daily.index',compact('dailypromos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
$locationtypes=Locationtype::all();
         return view('admin.promocodes.daily.create',compact('locationtypes'));
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
            'locationtype'=>'required',
            'percent'=>'required',
            'comment'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            
            ]);
       $dailypromo= Dailypromo::Create([

            'locationtype_id'=>strtoupper(request('locationtype')),

            'percent'=>strtoupper(request('percent')),

            'comment'=>request('comment'),
            'start_date'=>Carbon::parse(request('start_date')),
            'end_date'=>Carbon::parse(request('end_date')),
            
            ]);
       
       
        return redirect()->route('admin.promocodes.daily.index');
        
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dailypromo  $dailypromo
     * @return \Illuminate\Http\Response
     */
    public function show(Dailypromo $dailypromo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dailypromo  $dailypromo
     * @return \Illuminate\Http\Response
     */
    public function edit(Dailypromo $dailypromo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dailypromo  $dailypromo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dailypromo $dailypromo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dailypromo  $dailypromo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dailypromo $dailypromo)
    {
        //
    }
}
