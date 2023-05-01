<?php

namespace App\Observers;

use App\AvailabilityConstraint;

class AvailabilityConstraintObserver
{
    /**
     * Handle the availability constraint "created" event.
     *
     * @param  \App\AvailabilityConstraint  $availabilityConstraint
     * @return void
     */
    public function created(AvailabilityConstraint $availabilityConstraint)
    {
        //
    }

    /**
     * Handle the availability constraint "updated" event.
     *
     * @param  \App\AvailabilityConstraint  $availabilityConstraint
     * @return void
     */
    public function updated(AvailabilityConstraint $availabilityConstraint)
    {
        //
    }

    /**
     * Handle the availability constraint "deleted" event.
     *
     * @param  \App\AvailabilityConstraint  $availabilityConstraint
     * @return void
     */
    public function deleted(AvailabilityConstraint $availabilityConstraint)
    {
        //
    }

    /**
     * Handle the availability constraint "restored" event.
     *
     * @param  \App\AvailabilityConstraint  $availabilityConstraint
     * @return void
     */
    public function restored(AvailabilityConstraint $availabilityConstraint)
    {
        //
    }

    /**
     * Handle the availability constraint "force deleted" event.
     *
     * @param  \App\AvailabilityConstraint  $availabilityConstraint
     * @return void
     */
    public function forceDeleted(AvailabilityConstraint $availabilityConstraint)
    {
        //
    }
}
