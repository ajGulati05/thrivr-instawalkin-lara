<?php

namespace App\Observers;

use App\Project;
use App\Http\Traits\v2\TimekitTraitV2;
use Laravel\Nova\Actions\Action;
use App\Http\Requests\CreateProjectRequest;

class ProjectObserver
{
    use TimekitTraitV2;
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        //Now we create a timekit project
        $createProjectRequest = new CreateProjectRequest();
        $createProjectRequest->name = $project->name; //which name should be?
        $createProjectRequest->slug = $project->slug;
        $createProjectRequest->graph = 'instant';
        $createProjectRequest->what = $project->name;
        $createProjectRequest->where = 'TBA';
        $createProjectRequest->description = $project->description;
        $createProjectRequest->mode = "roundrobin_random"; //todo: check what this is
        $createProjectRequest->length = $project->length;
        $createProjectRequest->from = "1 hour";
        $createProjectRequest->to = "4 weeks";
        $createProjectRequest->buffer = $project->buffer;
        $createProjectRequest->ignore_all_day_events = false;
        $createProjectRequest->manager_resource = $project->timekit_project_id;

        $responseProjectTimekit = $this->createProject($createProjectRequest);
        $projectTimekitId = $responseProjectTimekit['data']['id'];
        Project::find($project->id)->update(['timekit_project_id' => $projectTimekitId]);
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updated(Project $project)
    { }

    /**
     * Handle the project "deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {

        
     }

    /**
     * Handle the project "restored" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function restored(Project $project)
    { }

    /**
     * Handle the project "force deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    { }
}
