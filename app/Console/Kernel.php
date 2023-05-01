<?php

namespace App\Console;

use App\Events\CaptureStripeBookings;
use App\Events\UpdateStripeBookings;
use App\Events\AutomatedReceiptsEvent;
use App\Events\TwentyFourHourBookingNotificationEvent;
use App\Events\RunCalSyncEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      

     $schedule->call(function(){
        Log::info('Running Calendar Sync');
        event(new RunCalSyncEvent());
      })->everyFiveMinutes() ;

      $schedule->call(function () {
       Log::debug('Running Capture Stripe');
            event(new CaptureStripeBookings());
            Log::debug('Running Authorize Stripe');
            event(new UpdateStripeBookings());
         })->daily();
    
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
