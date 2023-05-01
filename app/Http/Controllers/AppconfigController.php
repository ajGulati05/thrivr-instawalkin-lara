<?php

namespace App\Http\Controllers;

use App\Appconfig;
use Illuminate\Http\Request;
use App\Http\Resources\AppConfigResource;
class AppconfigController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appconfig  $appconfig
     * @return \Illuminate\Http\Response
     */
    public function show(Appconfig $appconfig)
    {
        //

       return  Appconfig::all()->keyBy('codevalue');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appconfig  $appconfig
     * @return \Illuminate\Http\Response
     */
    public function edit(Appconfig $appconfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appconfig  $appconfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appconfig $appconfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appconfig  $appconfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appconfig $appconfig)
    {
        //
    }
}
