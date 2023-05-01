<?php

namespace App\Http\Controllers\Managersapi\Booking;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Booking;
use App\Receipt;
use Carbon\Carbon;
use App\Notifications\ReceiptNotification;

class ReceiptController extends Controller
{
    public function send(Booking $booking){
        try {
            // Authorize as per booking controller?
            ;
      
            $receipt = Receipt::create([
                "booking_id" => $booking->id,
                "request_date" => Carbon::now(),
                "requested_by" => 'therapist',
                "requested_by_id" => $booking->manager_id,     // Manager is requesting this receipt
                "duplicated" => $booking->receipts()->exists()
            ]);

            $bookable=$receipt->bookings->bookable;
            $bookable->notify(new ReceiptNotification($receipt));
        }
        catch(\Exception $e){ 
            Log::critical('Receipt notification not sent Receipt ID'.$receipt->id);
            Log::debug('Exception: ' . $e);
        }

        // Success
        return response()->json(["status"=>true]);
    }

}
