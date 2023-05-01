<?php

namespace App\Observers;

use App\Gender;
use App\Manager;

use Illuminate\Http\Request;
use App\Http\Traits\v2\TimekitTraitV2;
use App\Project;
use App\Http\Requests\DettachResourceFromProjectRequest;
use Illuminate\Support\Facades\Log;
use App\ManagerSpeciality;
class ManagerObserver
{
    use TimekitTraitV2;
    /**
     * Handle the manager "created" event.
     *
     * @param  \App\Manager  $manager
     * @return void
     */
    public function created(Manager $manager)
    {

     //   $slug=str_replace(" ", "-", $manager->first_name)."-".str_replace(" ", "-", $manager->last_name)."-".str_replace(" ", "-", $manager->business_name);
        if($manager->product_code=='A')
        {
              
       $responseResourceTimekit = $this->createResource($manager);
        $manager->update(['timekit_resource_id' => $resourceTimekitId]);
        }
        else{
        //     $manager->update(['slug'=>$slug]);
        }
     $this->createAvailabilityConstraint($manager);
      $this->createManagerNotifications($manager);
        $this->createManagerSpecialties($manager);//Modalities is specialties
        $this->createManagerProjects($manager);
    }

    /**
     * Handle the manager "updated" event.
     *
     * @param  \App\Manager  $manager
     * @return void
     */
    public function updated(Manager $manager)
    { 

      
        if($manager->product_code=='A' && is_null($manager->timekit_resource_id)){
     

       $responseResourceTimekit = $this->createResource($manager);
      $resourceTimekitId = $responseResourceTimekit['data']['id'];
        $manager->update(['timekit_resource_id' => $resourceTimekitId]);
        }
      
        //TODO NOTIFY TO CHANGE SLUG
    }

    /**
     * Handle the manager "deleted" event.
     *
     * @param  \App\Manager  $manager
     * @return void
     */
    public function deleted(Manager $manager)
    {
        $project = $manager->projects()
            ->wherePivot('manager_id', $manager->id)
            ->first();
        //this is asumming is a soft delete
        if (!empty($project)) {
            $dettachResourceFromProjectRequest = new DettachResourceFromProjectRequest();
            $dettachResourceFromProjectRequest->timekit_project_id = $project->timekit_project_id;
            $dettachResourceFromProjectRequest->timekit_resource_id = $manager->timekit_resource_id;

            $this->dettachResourceFromProject($dettachResourceFromProjectRequest);
        }
    }


   public function createAvailabilityConstraint(Manager $manager){
        $manager->availabilityConstraint()->create();
   }
    public function createManagerNotifications(Manager $manager){
        $manager->managernotifications()->create();
   }

   public function createManagerSpecialties(Manager $manager){
        $managerSpecialties=ManagerSpeciality::whereIn('code',['R','T'])->get()->pluck('id');
        $manager->manager_specialities()->attach($managerSpecialties);
   }
      public function createManagerProjects(Manager $manager){
        $projects=Project::all()->pluck('id');
        $manager->projects()->attach($projects);
   }
}
