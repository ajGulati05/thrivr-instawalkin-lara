<?php

namespace App\Http\Controllers;
use DB;
use App\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
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
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transactions $transactions)
    {
        //
    }

    public function getArchives()
    {
         // return  Transactions::latest()->accepted()->filter(['day'=>'14','month'=>'december','year'=>'2018'])->get();

 /*select count(*) as countvalue, year(b.start_week) as startyear, monthname(b.start_week) as startmonthname, year(b.end_week) as endyear, monthname(b.end_week) as endmonthname, day(b.start_week) as startdate, day(b.end_week) as enddate  from transactions t, biweeklys b 
where (t.created_at between b.start_week and b.end_week)
group by startyear,startmonthname,endyear,endmonthname,enddate,startdate
order by min(t.created_at) desc*/
        return JSON_ENDCODE(DB::select(DB::raw('select count(*) as countvalue, year(b.start_week) as startyear, monthname(b.start_week) as startmonthname, year(b.end_week) as endyear, monthname(b.end_week) as endmonthname, day(b.start_week) as startdate, day(b.end_week) as enddate  from transactions t, biweeklys b 
where (t.created_at between b.start_week and b.end_week)
group by startyear,startmonthname,endyear,endmonthname,enddate,startdate
order by min(t.created_at) desc ' )));
            //->groupBy('startyear,startmonthname,endyear,endmonthname,enddate,startdate')
           // ->orderByRaw('min(created_at) desc')
            //->get();

           

    }
}
