<?php
namespace App\Http\Controllers\TherapistApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TherapistApi\BookingAdapterResource;

use App\Manager;
use App\Booking;
use App\BookingPricing;
class TherapistBookingController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //Resource::withoutWrapping();
        //$this->middleware('passwordchange',['except' => 'firsttime']);
    }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getAnalytics(Request $request){
        $bookings=Booking::filter($request)->where('manager_id',Auth::user()->id)->get();
        $bookingIds=$bookings->pluck('id');
        $managerAnalytics=BookingPricing::activeBookingPricing()->whereIn('booking_id',
        $bookingIds)->get();
        $bookingCount=$managerAnalytics->count();
        $totalAmount=$managerAnalytics->sum('amount');
        $totalTaxAmount=$managerAnalytics->sum('tax_amount');
        $totalTipAmount=$managerAnalytics->sum('tip_amount');
        $cashAmount=$managerAnalytics->sum('cash_amount');
        $creditCardAmount=$managerAnalytics->sum('credit_card_amount');
        $directBillingAmount=$managerAnalytics->sum('direct_billing_amount');
        $cancelAmount=0;
        $resecheduleAmount=0;
        $instaWalkinPayoutAmount=0;
        return response([
            'BOOKING_COUNT'=>$bookingCount,
            'TOTAL_AMOUNT'=>$totalAmount,
            'TOTAL_TAX_AMOUNT'=>$totalTaxAmount,
            'TOTAL_TIP_AMOUNT'=>$totalTipAmount,
            'CASH_AMOUNT'=> $cashAmount,
           'CREDIT_CARD_AMOUNT'=>$creditCardAmount,
           'DIRECT_BILLING_AMOUNT'=>$directBillingAmount,
           'CANCEL_AMOUNT'=>$cancelAmount,
           'RESECHEDULE_AMOUNT'=>$resecheduleAmount,
           'INSTAWALKING_FEES'=>$instaWalkinPayoutAmount
        ]);
        //cashpayment 
        //

    }
      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {

          //$clients=$manager->skip($request->_start)->take($request->_end-$request->_start)
        // ->orderBy($request->_sort,$request->_order)->get();
        $bookingsByManager=Auth::user()->load('bookings.bookable');
        Log::debug($bookingsByManager->bookings);
        $bookingAdapterResource=  BookingAdapterResource::collection($bookingsByManager->bookings);
        //Log::debug($bookingAdapterResource);
        
         $paginatedBookings=$bookingAdapterResource->slice($request->_start)->take($request->_end-$request->_start);

           if(strtolower($request->_order=='asc')){
           $paginatedBookingsSorted=$paginatedBookings->sortBy($request->_sort)->values()->all();
         }
         else{
        $paginatedBookingsSorted=$paginatedBookings->sortByDesc($request->_sort)->values()->all();
         }
         return response($paginatedBookingsSorted)
          ->header('x-total-count', $bookingsByManager->bookings->count()); 
        
    }

}
