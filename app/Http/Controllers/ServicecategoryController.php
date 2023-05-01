<?php

namespace App\Http\Controllers;

use App\Servicecategory;
use Illuminate\Http\Request;
use App\Http\Resources\UsersApi\Servicecategories as ServiceCategoryResource;
class ServicecategoryController extends Controller
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
     * @param  \App\servicecategory  $servicecategory
     * @return \Illuminate\Http\Response
     */
    public function show(servicecategory $servicecategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\servicecategory  $servicecategory
     * @return \Illuminate\Http\Response
     */
    public function edit(servicecategory $servicecategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\servicecategory  $servicecategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, servicecategory $servicecategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\servicecategory  $servicecategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(servicecategory $servicecategory)
    {
        //
    }

     public function getServiceCategory(){
            return  ServiceCategoryResource::collection(Servicecategory::all());
    }

    
}
