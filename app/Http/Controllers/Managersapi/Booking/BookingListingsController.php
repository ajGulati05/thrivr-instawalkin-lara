<?php

namespace App\Http\Controllers\Managersapi\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Booking;
use App\Http\Resources\TherapistApi\v2\TherapistBookingResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Traits\v2\ReconcileUserTypeTrait;
use Carbon\Carbon;
class BookingListingsController extends Controller
{
    use ReconcileUserTypeTrait;

    public function list(Request $request)
    {

      
            $bookings = Auth::user()->bookings()->where(function ($query) {
               $query->where('booking_status', '!=', 'D')
                     ->orWhereNull('booking_status');
           })->with('managerSpeciality', 'bookable', 'userGuests', 'project')
                ->getQuery();
      

          
        $builtQuery = QueryBuilder::for($bookings)
            ->allowedFilters([
                AllowedFilter::scope('date_betweens'),
            ])
            ->get();


        $collectionToReturn = TherapistBookingResource::collection($builtQuery);
        return response()->json(["data" => $collectionToReturn,"total"=>$bookings->count(), "status" => true], 200);

    }


    public function show(Booking $booking)
    {
        if ($this->authorize('ownsBooking', $booking)) {
            $bookingDetail = $booking->load("managerSpeciality", "bookable", "userGuests");
            return response()->json(["data" => new TherapistBookingResource ($bookingDetail), "status" => true])
                ->header('x-total-count', $bookingDetail->count());;
        }
    }


    public function clientsBookingWithTherapist(Request $request)
    {
        $manager=Auth::user();
        $today= Carbon::now();
        $client= $this->reconcileUser($request);
        $confirmedBookings=$client->books()->where('manager_id',$manager->id)->
        where('start','<',$today)->orderByDesc('start')->get();
        $upcomingBookings=$client->books()->where('manager_id',$manager->id)->where('start','>=',$today)->orderBy('start')->get();

     
        $upcomingBookingsCount=$upcomingBookings->count();
        $confirmedBookingsCount=$confirmedBookings->count();
        return response()->json(["data"=>[
            "confirmedBookings"=> TherapistBookingResource::collection($confirmedBookings),
            "upcomingBookings"=> TherapistBookingResource::collection($upcomingBookings),
            "upcomingBookingsCount"=>$upcomingBookingsCount,
            "confirmedBookingsCount"=>$confirmedBookingsCount,
            "total"=> $confirmedBookingsCount+$confirmedBookingsCount,
            "status"=>true]]);
    }


}



// Booking route you are sending back 
// $bookings =$manager->bookingsBetweenDate($start,$end)->load('managerSpeciality','bookable','userGuests');