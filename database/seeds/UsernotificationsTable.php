<?php

use Illuminate\Database\Seeder;
use App\UserNotifications;
use Illuminate\Support\Facades\Log;
class UsernotificationsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $userNotifications=UserNotifications::where('future_reminder',0)->get();


        foreach($userNotifications as $userNotification){

                $userNotification->product_update=0;
                $userNotification->save();
            

        }
    }
}
