<?php

namespace App\Http\Controllers;

use App\Instaprice;
use App\Servicecategory;
use Illuminate\Http\Request;
use App\Http\Resources\InstapriceResource;
class InstapriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instaprices=Instaprice::all();
      
        return view('admin.business.instaprices.index',compact('instaprices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         ///get all locationtypes tied to   
      $servicecategories=Servicecategory::all();
     
      return view('admin.business.instaprices.create',compact('servicecategories'));
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
            
            'price'=>'required|min:1',
            
            ]);
       $instaprice= Instaprice::Create([

            'servicecategories_id'=>request('servicecategorie')[0],

            'price'=>request('price'),
           

            ]);
       
       
           $instaprices=Instaprice::all();
      
        return view('admin.business.instaprices.index',compact('instaprices'));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Instaprice  $instaprice
     * @return \Illuminate\Http\Response
     */
    public function show(Instaprice $instaprice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Instaprice  $instaprice
     * @return \Illuminate\Http\Response
     */
    public function edit(Instaprice $instaprice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Instaprice  $instaprice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instaprice $instaprice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Instaprice  $instaprice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instaprice $instaprice)
    {
        //
    }

     public function getServiceCategoryV3(){
        $collection=Instaprice::with('servicecategories')->instapricescurrentdates()->get();
       
            return  InstapriceResource::collection($collection->sortBy('price'));
    }
}
