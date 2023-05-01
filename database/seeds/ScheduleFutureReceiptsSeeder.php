<?php

use Illuminate\Database\Seeder;
use Thomasjohnkane\Snooze\ScheduledNotification;
use Carbon\Carbon;
use App\Booking;
use App\Receipt;
use App\Notifications\ReceiptNotification;
use Illuminate\Support\Facades\Log;
class ScheduleFutureReceiptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
      $allBookings=Booking::where('end','>=',Carbon::now())->get();
      Log::debug("all bookings");
       foreach ($allBookings as $booking) {
              $receiptDate = Carbon::parse($booking->end)->addMinutes(5);    
      $receipt = Receipt::create([
                "booking_id" => $booking->id,
                "request_date" => $receiptDate->toDateTimeString(),
                "requested_by" => 'System',
                "requested_by_id" => 0,
                "duplicated" => false
            ]);
      try {
           $booking->bookable->notifyAt(new ReceiptNotification($receipt), $receiptDate);                               //Carbon::parse($booking->end)->addMinutes(5));    
            
        } 
        catch (\Exception $e) { // Using a generic exception
            Log::debug('Scheduled booking issue' . $e);
            Log::critical('Scheduled booking issue' . $booking->id);
        }


        }
    }
}
