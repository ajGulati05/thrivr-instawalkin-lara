<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use App\Transactions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
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


    protected function validator(array $data)
    {
          
          
       $validator=Validator::make($data, [
            'transaction_id'=>'required',
            'review_score'=>'required|min:1'
            ]);
          
     return $validator; 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

       $validator =$this->validator($request->all());

       $transactions =Transactions::where('id',request('transaction_id'))->first();
         $review = new Review;
       if ($user->can('create', [$review,$transactions])) {
    //

    if ($validator->fails())
        {
      return response()->json(['error'=>'true','message'=>$validator->messages(),'code'=>'800']);
    
         }

         
       

            $review->transaction_id=$request->transaction_id;
             $review->review_score=$request->review_score;
            $review->review_comment=$request->review_comment;
            $review->save();
           
         


        return response()->json(['error'=>'false','review'=>$review,'code'=>'200'],200);
        }
        
         return response()->json(['error'=>'true','message'=>'Unauthorized','code'=>'500']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
