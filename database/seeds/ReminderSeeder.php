<?php

use Illuminate\Database\Seeder;
use App\Booking;
use App\User;
use App\Guest;
use Carbon\Carbon;
use App\Notifications\UserBookingNotification;
use App\Notifications\IntakeFormReminderNotification;
use App\Notifications\BookAMassageReminderNotification;
use Illuminate\Support\Facades\Log;
class ReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

      $upcomingBookings=Booking::where('start','>',Carbon::now()->addHours(1))->whereNull('booking_status')->get();

      foreach ($upcomingBookings as $upcomingBooking) {
         try{

            if(Carbon::parse($upcomingBooking->start)->diffInHours(Carbon::now())<24){
                    $upcomingBooking->bookable->notifyAt(new UserBookingNotification($upcomingBooking,1),Carbon::now()->addMinutes(60));
            } 
                else{
                         $upcomingBooking->bookable->notifyAt(new UserBookingNotification($upcomingBooking,1),Carbon::parse($upcomingBooking->start)->addDays(-1));
                         $upcomingBooking->bookable->notifyAt(new IntakeFormReminderNotification($upcomingBooking),Carbon::parse($upcomingBooking->start)->addHours(-2));
                    }
            }
        catch(\Exception $e){ // Using a generic exception

                Log::critical('Scheduled booking issue'.$upcomingBooking->id .$e);
            }
      }





      $futureRemindersUsers=User::get();

      foreach ($futureRemindersUsers as $futureRemindersUser) {
       $booking= $futureRemindersUser->books->sortByDesc('start')->first();
       if(!is_null($booking)>0){
                if($booking->manager_id!=35 || $booking->manager_id!=41){


                   if(Carbon::parse($booking->start)->diffInDays(Carbon::now())<30){
                     $futureRemindersUser->notifyAt(new BookAMassageReminderNotification(),Carbon::parse($booking->start)->addDays(30));
                       
                      }
                      else {
                        $futureRemindersUser->notifyAt(new BookAMassageReminderNotification(),Carbon::now()->addMinutes(1));
                        
                      }
                    
                  }
            }
      }



   $futureRemindersGuests=Guest::get();

      foreach ($futureRemindersGuests as $futureRemindersGuest) {
       $booking= $futureRemindersGuest->books->sortByDesc('start')->first();
       if(!is_null($booking)>0){
 if($booking->manager_id!=35 || $booking->manager_id!=41){

                
                   if(Carbon::parse($booking->start)->diffInDays(Carbon::now())<30){
                     $futureRemindersGuest->notifyAt(new BookAMassageReminderNotification(),Carbon::parse($booking->start)->addDays(30));
                       
                      }
                     else {
                        $futureRemindersGuest->notifyAt(new BookAMassageReminderNotification(),Carbon::now()->addMinutes(1));
                        
                      }
                  
                  }



            }
            }
      }


    
}
