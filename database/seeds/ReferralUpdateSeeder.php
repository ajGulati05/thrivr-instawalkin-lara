<?php

use App\Notifications\UserBookingNotification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\User;
use App\Notifications\ReferralUpdateNotification;

class ReferralUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        $users = User::where('created_at','<','2020-11-01')->get();

        foreach ($users as $user) {
            // applying the promo code
            $user->notifyAt(new ReferralUpdateNotification(), Carbon::now()->addMinutes(10));

        }
    }
}
