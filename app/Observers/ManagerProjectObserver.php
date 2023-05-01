<?php

namespace App\Observers;

use App\ManagerProject;
use App\Http\Requests\AttachResourceToProjectRequest;
use App\Http\Traits\TimekitTrait;
use App\Manager;
use App\Project;
use App\Http\Requests\DettachResourceFromProjectRequest;

class ManagerProjectObserver
{
    use TimekitTrait;
    /**
     * Handle the manager project "created" event.
     *
     * @param  \App\ManagerProject  $managerProject
     * @return void
     */
    public function created(ManagerProject $managerProject)
    {
        //We create a timekit resource
        // This could be done in an OBSERVER TOO

        $attachResourceToProjectRequest = new AttachResourceToProjectRequest();
        $manager = Manager::find($managerProject->manager_id);
        $project = Project::find($managerProject->project_id);

        $timekit_resource_id = $manager->timekit_resource_id;
        if(!is_null($timekit_resource_id)){
        $attachResourceToProjectRequest->timekit_project_id = $project->timekit_project_id;
        $attachResourceToProjectRequest->resource_id = $timekit_resource_id;

        $this->attachResourceToProject($attachResourceToProjectRequest);
    }
    }

    /**
     * Handle the manager project "updated" event.
     *
     * @param  \App\ManagerProject  $managerProject
     * @return void
     */
    public function updated(ManagerProject $managerProject)
    {
        //
    }

    /**
     * Handle the manager project "deleted" event.
     *
     * @param  \App\ManagerProject  $managerProject
     * @return void
     */
    public function deleted(ManagerProject $managerProject)
    {
        $project = Project::find($managerProject->project_id);
        $manager = Manager::find($managerProject->manager_id);
        //this is asumming is a soft delete
        if (!empty($project)) {
            $dettachResourceFromProjectRequest = new DettachResourceFromProjectRequest();
            $dettachResourceFromProjectRequest->timekit_project_id = $project->timekit_project_id;
            $dettachResourceFromProjectRequest->timekit_resource_id = $manager->timekit_resource_id;

            $this->dettachResourceFromProject($dettachResourceFromProjectRequest);
        }
    }

    /**
     * Handle the manager project "restored" event.
     *
     * @param  \App\ManagerProject  $managerProject
     * @return void
     */
    public function restored(ManagerProject $managerProject)
    {
        //
    }

    /**
     * Handle the manager project "force deleted" event.
     *
     * @param  \App\ManagerProject  $managerProject
     * @return void
     */
    public function forceDeleted(ManagerProject $managerProject)
    {
        //
    }
}
