<?php

namespace App\Http\Controllers\Managersapi\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\v2\ReconcileUserTypeTrait;
use Carbon\Carbon;
use App\Booking;
class ClientAnalyticsController extends Controller
{
use ReconcileUserTypeTrait;

    public function getClientAnalytics(Request $request)
    {
          $manager=Auth::user();
            $today= Carbon::now();
           $client= $this->reconcileUser($request);
           $bookings=$client->books()->where('manager_id',$manager->id)->get();

           $confirmedBookings=$bookings->where('start','<=',$today)->whereNull('booking_status');
           $upcomingBookings=$bookings->where('start','>',$today)->whereNull('booking_status');
           $noShowAppointments=$bookings->where('start','>',$today)->whereIn('booking_status',[Booking::RESCHEDULED_BOOKING_STATUS
               ,Booking::CANCELLED_BOOKING_STATUS]);
           $lastVisit=$client->books()->where('manager_id',$manager->id)->whereNull('booking_status')->latest()->first();
           $lastVisitInDays=0;
         
            if(isset($lastVisit)){
             $lastVisitInDays= $today->diffInDays($lastVisit->start);
            }

           return response()->json([
                "confirmed_appointments"=>$confirmedBookings->count(),
                "upcoming_appointments"=>$upcomingBookings->count(),
                "no_show"=>$noShowAppointments->count(),
                "last_visit_in_days"=>$lastVisitInDays


           ],200);

    }


 
}