<?php

namespace App\Http\Controllers;

use App\Corprequest;
use Illuminate\Http\Request;

class CorprequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
          
         $this->validate(request(),[
            
            'code'=>'required',
            'email'=>'required',
            'company'=>'required'
            ]);
         
       $corpRequest= Corprequest::Create([

            'email'=>request('email'),
            'code'=>request('code'),
            'company'=>request('company'),

            ]);
       
      return $corpRequest;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Corprequest  $corprequest
     * @return \Illuminate\Http\Response
     */
    public function show(Corprequest $corprequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Corprequest  $corprequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Corprequest $corprequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Corprequest  $corprequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Corprequest $corprequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Corprequest  $corprequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corprequest $corprequest)
    {
        //
    }
}
