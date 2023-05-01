<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


// Email Verification
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

   
//
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

          // Add the listener
      Registered::class => [
            SendEmailVerificationNotification::class,
        ],
      
        'App\Events\UpdateStripeBookings' => [
            'App\Listeners\UpdateStripeBookingsListener',
        ],

        'App\Events\CaptureStripeBookings' => [
            'App\Listeners\CaptureStripeBookingsListener',
        ],
          'App\Events\AutomatedReceiptsEvent' => [
            'App\Listeners\AutomatedReceiptsListener',
        ],
          
       'App\Events\RunCalSyncEvent' => [
            'App\Listeners\RunCalSyncListener',
        ],     
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
          

        //
    }


}
