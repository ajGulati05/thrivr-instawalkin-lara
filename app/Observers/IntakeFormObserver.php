<?php

namespace App\Observers;

use App\IntakeForm;
use Illuminate\Support\Facades\Log;
use App\Manager;
class IntakeFormObserver
{
    /**
     * Handle the intake form "created" event.
     *
     * @param  \App\IntakeForm  $intakeForm
     * @return void
     */
    public function created(IntakeForm $intakeForm)
    {
        //

      $intakeForms=$intakeForm->intakeFormable()
      ->first()
      ->intakeforms()
      ->active()
      ->where('id','!=',$intakeForm->id)
      ->where('userguest_id',$intakeForm->userguest_id)
      ->get();

      foreach($intakeForms as $intakeForm){
            $intakeForm->update(['active'=>0]);
      }

    }

  /**
     * Handle the covid form "updated" event.
     *
     * @param  \App\IntakeForm  $intakeForm
     * @return void
     */
    public function updated(IntakeForm $intakeForm){
     
     
       // $managerRelationship=$intakeForm->managers()->update(['active'=>0]);


    }

}




//intakeforms by a user for a manager 

//intakeforms by a user with a user_id for a manag er





//relation right now is intakeform to user