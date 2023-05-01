<?php

use Illuminate\Database\Seeder;
use App\Endorsement;
use App\Booking;
use Illuminate\Support\Facades\Log;
class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         

     /*   $booking=Booking::all();
        $count=1;
          foreach($booking as $bookingmain){
              Log::debug($count++);
                 factory(App\Review::class)
                 ->states('verifieds')
                 ->create(['booking_id'=>$bookingmain->id,'manager_id'=>$bookingmain->manager_id,'reviewable_id'=>$bookingmain->bookable_id]);
                
                }*/
     
      factory(App\Review::class, 200)
           ->create();





    }
}
