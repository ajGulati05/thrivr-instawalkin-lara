<?php

namespace App\Listeners;

use App\Events\ContactFormSubmit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactEmailToTeam
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ContactFormSubmit  $event
     * @return void
     */
    public function handle(ContactFormSubmit $event)
    {
        //
    }
}
