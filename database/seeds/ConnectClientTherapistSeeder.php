<?php

use Illuminate\Database\Seeder;
use App\Booking;
use Carbon\Carbon;
class ConnectClientTherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $bookings=Booking::userType()->select('bookable_id','manager_id')->groupBy('bookable_id','manager_id')->get();


        foreach($bookings as $booking){


            
        	 DB::table('client_therapist')->insert([
	    	 'user_id'=>$booking->bookable_id,
	    	 'manager_id'=>$booking->manager_id,
	    	 'updated_at'=>Carbon::now(),
	    	 'created_at'=>Carbon::now()
        ]);
        }
    }
}
