<?php

namespace App\Observers;

use App\ProjectPricing;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class ProjectPricingObserver
{
    /**
     * Handle the project pricing "created" event.
     *
     * @param  \App\ProjectPricing  $projectPricing
     * @return void
     */
    public function created(ProjectPricing $projectPricing)
    {
        //creation of the end date as null
        DB::table('project_pricings')
            ->where('id', $projectPricing->id)
            ->update(['end_date' => null]);

        //update the rest of the project pricings
        DB::table('project_pricings')
            ->where('id', '!=', $projectPricing->id)
            ->where('project_id','=',$projectPricing->project_id)
            ->where('end_date', null)
            ->update(['end_date' => $projectPricing->start_date]);
    }

    /**
     * Handle the project pricing "updated" event.
     *
     * @param  \App\ProjectPricing  $projectPricing
     * @return void
     */
    public function updated(ProjectPricing $projectPricing)
    {
        //
    }

    /**
     * Handle the project pricing "deleted" event.
     *
     * @param  \App\ProjectPricing  $projectPricing
     * @return void
     */
    public function deleted(ProjectPricing $projectPricing)
    {
        //
    }

    /**
     * Handle the project pricing "restored" event.
     *
     * @param  \App\ProjectPricing  $projectPricing
     * @return void
     */
    public function restored(ProjectPricing $projectPricing)
    {
        //
    }

    /**
     * Handle the project pricing "force deleted" event.
     *
     * @param  \App\ProjectPricing  $projectPricing
     * @return void
     */
    public function forceDeleted(ProjectPricing $projectPricing)
    {
        //
    }
}
