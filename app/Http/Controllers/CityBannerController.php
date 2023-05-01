<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Booking;
use Carbon\Carbon;
use App\BookingPricing;
class CityBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $request->validate([
 'latitude' => 'sometimes|numeric',
 'longitude'=>'sometimes|numeric',
    ]);

            $start = Carbon::parse('2020-11-01');//Carbon::now()->startOfMonth();
            $end = Carbon::now();
            $startText=Carbon::parse($start)->isoFormat('MMMM Do, YYYY');
            $booking=Booking::whereBetween('start',[$start,$end]);
            $bookingCount=$booking->count();
            $bookingPricings=BookingPricing::whereIn('booking_id',$booking->pluck('id'))->where('active',true)->get();
            $amount_earned=number_format((float)$bookingPricings->sum('amount')+$bookingPricings->sum('tax_amount')+$bookingPricings->sum('tip_amount'));


           $message=$bookingCount==0?"RMT's in yur area have made about $3,000 this month":"Your Business Can Thrive! ";
        return response()->json(["data"=>[
            "amount_earned"=>$amount_earned,
            "bookings"=>$bookingCount,
            "date"=>$startText,
            "message"=>$message



        ],"status"=>true]);
  
    }

  
}
