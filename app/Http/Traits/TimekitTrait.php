<?php

namespace App\Http\Traits;

use App\Http\Traits\GuzzleCallsTrait;
use App\Http\Requests\CreateResourceRequest;
use App\Http\Requests\CreateProjectRequest;
use App\GuzzleRequest;
use Config;
use App\Http\Requests\AttachResourceToProjectRequest;
use App\Http\Requests\BookRequest;
use App\Http\Requests\CancelBookingTimekitRequest;
use App\Http\Requests\DettachResourceFromProjectRequest;
use App\Http\Requests\GetTimekitOpenSlotsByDateRequest;
use App\Http\Requests\SetResourceTimeConstraintsRequest;
use App\Http\Resources\CommonResources\ProjectPricingResource;
use App\Project;
use App\ProjectPricing;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

trait TimekitTrait
{
    use GuzzleCallsTrait;
     protected $timkeit_dev_key;



   public function __construct() {
        $this->timkeit_dev_key = config('constants.configurations.timekit_dev_key');
}

    public function createProject(CreateProjectRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/projects';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key; //todo: what is default

        $bodyGuzzle['name'] = $request->name;

        $resources = array($request->manager_resource);
        $bodyGuzzle['resources'] = $resources;

        $availability['mode'] = $request->mode;
        $availability['length'] = $request->length;
        $availability['from'] = $request->from;
        $availability['to'] = $request->to;
        $availability['buffer'] = $request->buffer;
        $availability['ignore_all_day_events'] = $request->ignore_all_day_events;

        $bodyGuzzle['availability'] = $availability;

        $booking['graph'] = $request->graph;
        $booking['what'] = $request->name; //double check if it needs to be the same as the name
        $booking['where'] = $request->where;
        $booking['description'] = $request->description;

        $bodyGuzzle['booking'] = $booking;

        $guzzleRequest->body = $bodyGuzzle;

        $responseGuzzle = $this->guzzlePost($guzzleRequest);

        return $responseGuzzle;
    }

    public function createResource(CreateResourceRequest $request) //? is it necessary?
    {
        //Validate TODO
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/resources';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key; //todo: what is default

        $bodyGuzzle['name'] = $request->name;
        $bodyGuzzle['timezone'] = $request->timezone; //todo: Figure out what is timezone
        $bodyGuzzle['email'] = $request->email;

        $guzzleRequest->body = $bodyGuzzle;

        $responseGuzzle = $this->guzzlePost($guzzleRequest);
        return $responseGuzzle;
    }

    //this is for attaching one or more resources to a project
    public function attachResourceToProject(AttachResourceToProjectRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/projects/' . $request->timekit_project_id . '/resources';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key;

        $bodyGuzzle['resource_id'] = $request->resource_id;

        $guzzleRequest->body = $bodyGuzzle;

        $responseGuzzle = $this->guzzlePost($guzzleRequest);
        return $responseGuzzle;
    }

    public function dettachResourceFromProject(DettachResourceFromProjectRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/projects/' . $request->timekit_project_id . '/resources/' . $request->timekit_resource_id;
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key;
        $guzzleRequest->body = null;

        $responseGuzzle = $this->guzzleDelete($guzzleRequest);
        return $responseGuzzle;
    }

    public function setResourceTimeConstraintsTimekitTrait(SetResourceTimeConstraintsRequest $request)
    {

        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/resources/' . $request->timekit_resource_id;
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key;
        $guzzleRequest->body = $request->availability_constraints;
        
        $responseGuzzle = $this->guzzlePut($guzzleRequest);
        return $responseGuzzle;
    }

      public function getResourceTimeConstraintsTimekitTrait( $timekit_resource_id)
    {

        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/resources/' . $timekit_resource_id.'?include=availability_constraints';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key;
       // $guzzleRequest->body = $request->availability_constraints;

        $responseGuzzle = $this->guzzleGet($guzzleRequest);
        
        return $responseGuzzle;
    }


    //THIS FUNCTION IS USED BY USERS ONLY FOR NOW AND IS INCLUDING THE METADATA
    public function bookTimekit(BookRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/bookings';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth = config('constants.configurations.timekit_dev_key'); //todo: what is default

        $bodyGuzzle['resource_id'] = $request->timekit_resource_id;
        $bodyGuzzle['graph'] = $request->graph;
        $bodyGuzzle['start'] = $request->start;
        $bodyGuzzle['end'] = $request->end;
        $bodyGuzzle['what'] = $request->what;
        $bodyGuzzle['where'] = $request->where;
        $bodyGuzzle['description'] = $request->description;

        $customerObject["name"] = $request->customer_name;
        $customerObject["email"] = $request->customer_email;
        $customerObject['timezone'] = 'UTC'; //be aware this was burned by default for the time matching

        $bodyGuzzle['customer'] = $customerObject;

        //HERE METADATA
        $customerMetadata['name']=$request->customer_name;
        $customerMetadata['email']=$request->customer_email;
        $customerMetadata['timezone']='UTC';
        $customerMetadata['id']=$request->customer_id;

        $dataMeta['customer']=$customerMetadata;
        $dataMeta['manager_id']=$request->manager_id;
        $dataMeta['project_id']=$request->project_id;
        $dataMeta['start']=$request->start;
        $dataMeta['end']=$request->end;
        $dataMeta['app_source']=$request->app_source;
        $dataMeta['by_source']=$request->by_source;
        $dataMeta['paid_by']=$request->paid_by;

        // $project_pricing = Project::with('activeprojectpricing.calculatetax')->where('id', $request->project_id)->first();
        $project_pricing = Project::find($request->project_id);

        Log::debug('PROJECT PRICING');
        Log::debug(json_encode($project_pricing));
        $dataMeta['project_pricings']=new ProjectPricingResource($project_pricing->activeprojectpricing->first());

        $bodyGuzzle['meta']=$dataMeta;

        Log::debug('BODY GUZZLE');
        Log::debug($bodyGuzzle);

        $guzzleRequest->body = $bodyGuzzle;
        Log::debug('passes timekit request formation');
        Log::debug($guzzleRequest);

        $responseGuzzle = $this->guzzlePost($guzzleRequest);

        return $responseGuzzle;
    }

    public function getTimekitOpenSlotsByDate(GetTimekitOpenSlotsByDateRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/availability';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key; //todo: what is default

        Log::debug("REQUEST TIMEKIT");
        Log::debug($request);

        $bodyGuzzle['resources'] = [$request->resource_id];
        
            preg_match_all('/([\d]+)/', $request->length, $match);
            $x=$match[0];
            $newLength= $x[0]+15 ." minutes";
        //$bodyGuzzle['resources'] = ['de7b6521-71fb-4fb7-94ee-8d5833b79b27'];
        $bodyGuzzle['mode'] = "mutual";
        $bodyGuzzle['length'] = $newLength;
        $bodyGuzzle['timeslot_increments'] = $request->timeslot_increments;
        $bodyGuzzle['constraints'] = $request->constraints;
        $bodyGuzzle['output_timezone'] = "America/Regina";
        $bodyGuzzle['buffer']="15 minutes";
        $guzzleRequest->body = $bodyGuzzle;
        Log::debug('passes timekit request formation');

        $responseGuzzle = $this->guzzlePost($guzzleRequest);


        return $responseGuzzle;
    }

    public function cancelBookingTimekit(CancelBookingTimekitRequest $request)
    {
        $timekit_booking_id = $request->timekit_booking_id;

        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/bookings/' . $timekit_booking_id . '/cancel';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth =$this->timkeit_dev_key;

        $bodyGuzzle['id'] = $timekit_booking_id;
        $bodyGuzzle['action'] = 'cancel';
        $guzzleRequest->body = $bodyGuzzle;
        $responseGuzzle = $this->guzzlePut($guzzleRequest);

        Log::debug('CANCEL BOOKING TIMEKIT RESPONSE');

        return true;  
    }
}
