<?php

namespace App\Observers;

use App\CovidForm;

class CovidFormObserver
{
    /**
     * Handle the covid form "created" event.
     *
     * @param  \App\CovidForm  $covidForm
     * @return void
     */
    public function created(CovidForm $covidForm)
    {
          $covidForms=$covidForm->covidFormable()
      ->first()
      ->covidforms()
      ->active()
      ->where('id','!=',$covidForm->id)
      ->where('userguest_id',$covidForm->userguest_id)
      ->get();

      foreach($covidForms as $covidForm){
            $covidForm->update(['active'=>0]);
      }
    }

    /**
     * Handle the covid form "updated" event.
     *
     * @param  \App\CovidForm  $covidForm
     * @return void
     */
    public function updated(CovidForm $covidForm)
    {
         
        $bookingRelationship=$covidForm->bookings()->update(['active'=>0]);
    }

}
