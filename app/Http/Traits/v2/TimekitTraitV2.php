<?php

namespace App\Http\Traits\v2;

use App\Http\Traits\v2\GuzzleCallsTraitV2;
use App\Http\Traits\v2\PoolTrait;
use App\Http\Traits\v2\ICSParserTrait;
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

use Illuminate\Http\Request;

use App\Manager;
trait TimekitTraitV2
{
    use GuzzleCallsTraitV2,PoolTrait;
    use ICSParserTrait;

    private $mainTimekitUrl;
    protected $timkeit_dev_key;



   public function __construct() {
        $this->timkeit_dev_key = config('constants.configurations.timekit_dev_key');
}

    
  
    public function createProject(CreateProjectRequest $createProjectRequest)
    {
       
        $request = new Request();
        $request->url =Config::get('constants.urls.timekitapi'). '/projects/';
        $request->username_auth = null;
        $request->key_auth = $this->timkeit_dev_key;

      
      
        $postBody['name'] = $createProjectRequest->name;

        $resources = array($createProjectRequest->manager_resource);
        $postBody['resources'] = $resources;

        $availability['mode'] = $createProjectRequest->mode;
        $availability['length'] = $createProjectRequest->length;
        $availability['from'] = $createProjectRequest->from;
        $availability['to'] = $createProjectRequest->to;
        $availability['buffer'] = $createProjectRequest->buffer;
        $availability['ignore_all_day_events'] = $createProjectRequest->ignore_all_day_events;

        $postBody['availability'] = $availability;

        $booking['graph'] = $createProjectRequest->graph;
        $booking['what'] = $createProjectRequest->name; //double check if it needs to be the same as the name
        $booking['where'] = $createProjectRequest->where;
        $booking['description'] = $createProjectRequest->description;

        $postBody['booking'] = $booking;

        $request->body = $postBody;
   


        $response = $this->returnResponseJSON(config('enum.httpRequests.post'),$request);

        return $response;
    }

    public function createResource(Manager $manager) //? is it necessary?
    {

        $request = new Request();
        $request->url = config('constants.urls.timekitapi') . '/resources';
        $request->username_auth = null;
        $request->key_auth = $this->timkeit_dev_key; //todo: what is default

   
        $postBody['name'] = $manager->fullName;
        $postBody['timezone'] = $manager->timezone;//todo: Figure out what is timezone
        $postBody['email'] = $manager->email;

        $request->merge(['body'=>$postBody]);

        $response =$this->returnResponseJSON(config('enum.httpRequests.post'),$request);
        return $response;
    }

    //this is for attaching one or more resources to a project
    public function attachResourceToProject(AttachResourceToProjectRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = config('constants.urls.timekitapi') . '/projects/' . $request->timekit_project_id . '/resources';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth = $this->timkeit_dev_key;

        $bodyGuzzle['resource_id'] = $request->resource_id;

        $guzzleRequest->body = $bodyGuzzle;

        $responseGuzzle = makeHttpRequest(config('enum.httpRequests.post'),$guzzleRequest);
        return $responseGuzzle;
    }

    public function dettachResourceFromProject(DettachResourceFromProjectRequest $request)
    {
        $guzzleRequest = new GuzzleRequest();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/projects/' . $request->timekit_project_id . '/resources/' . $request->timekit_resource_id;
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth = $this->timkeit_dev_key;
        $guzzleRequest->body = null;

        $responseGuzzle = $this->guzzleDelete($guzzleRequest);
        return $responseGuzzle;
    }

    public function setResourceTimeConstraintsTimekitTrait(SetResourceTimeConstraintsRequest $request)
    {

        $guzzleRequest = new Request();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/resources/' . $request->timekit_resource_id;
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth = $this->timkeit_dev_key;
         $availabilityConstraints= json_decode($request->availability_constraints, true);
        $guzzleRequest->body = $availabilityConstraints ;
       
        $responseGuzzle = $this->returnResponseJSON(config('enum.httpRequests.put'),$guzzleRequest);
        return $responseGuzzle;
    }

      public function getResourceTimeConstraintsTimekitTrait($timekit_resource_id)
    {
        
        $request = new Request();
        $request->url =Config::get('constants.urls.timekitapi'). '/resources/' . $timekit_resource_id.'?include=availability_constraints';
        $request->username_auth = null;
        $request->key_auth = $this->timkeit_dev_key;
       // $guzzleRequest->body = $request->availability_constraints;

        $response = $this->returnResponseJSON(config('enum.httpRequests.get'),$request);
        
        return $response;
    }


    //THIS FUNCTION IS USED BY USERS ONLY FOR NOW AND IS INCLUDING THE METADATA
    public function bookTimekit(BookRequest $request,$allow_double_booking=false)
    {
        $guzzleRequest = new Request();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/bookings';
        $guzzleRequest->username_auth = null;
        $guzzleRequest->key_auth = config('constants.configurations.timekit_dev_key'); //todo: what is default
   $email=isset($request->customer_email)?$request->customer_email:"no-mail@thrivr.ca";
        $bodyGuzzle['resource_id'] = $request->timekit_resource_id;
        $bodyGuzzle['graph'] = $request->graph;
        $bodyGuzzle['start'] = $request->start;
        $bodyGuzzle['end'] = $request->end;
        $bodyGuzzle['what'] = $request->what;
        $bodyGuzzle['where'] = $request->where;
        $bodyGuzzle['description'] = $request->description;

        // allows double booking for when a therapist is modifying a booking.
        if($allow_double_booking){
            $bodyGuzzle['settings']['allow_double_bookings']= true;
        }
        

        $customerObject["name"] = $request->customer_name;
        $customerObject["email"] = $email;
        $customerObject['timezone'] = 'UTC';//be aware this was burned by default for the time matching

        $bodyGuzzle['customer'] = $customerObject;

        //HERE METADATA
        $customerMetadata['name']=$request->customer_name;
        $customerMetadata['email']=$email;
        $customerMetadata['timezone']=$timeZone=str_replace('_','/',$request->userTimezone);
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

   
        $bodyGuzzle['meta']=$dataMeta;

     

        $guzzleRequest->body = $bodyGuzzle;
      
       
        $responseGuzzle = $this->returnResponseJSON(config('enum.httpRequests.post'),$guzzleRequest);

        return $responseGuzzle;
    }


    public function getTimekitOpenSlotsByProject($timezone,$demodate,$todate){
        $guzzleRequest = new Request();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/availability';
        $guzzleRequest->username_auth = null;
      
        $guzzleRequest->key_auth = $this->timkeit_dev_key; //todo: what is default

   
        $bodyGuzzle['project_id']=config('constants.configurations.timekit_project_id');
       // $bodyGuzzle['resources'] = [$request->resource_id];
        //$bodyGuzzle['resources'] = ['de7b6521-71fb-4fb7-94ee-8d5833b79b27'];
        $bodyGuzzle['mode'] = "roundrobin_random";
        $bodyGuzzle['length'] ="45 minutes";
        $bodyGuzzle['timeslot_increments'] = "30 minutes";
        $bodyGuzzle['from'] =$demodate;
        $bodyGuzzle['to'] =$demodate;
        $bodyGuzzle['to'] =$todate;
        $bodyGuzzle['output_timezone'] =$timezone;
        $bodyGuzzle['buffer']="15 minutes";
        $guzzleRequest->body = $bodyGuzzle;
        Log::debug('passes timekit request formation');

        $responseGuzzle = $this->returnResponseJSON(config('enum.httpRequests.post'),$guzzleRequest);


        return $responseGuzzle;
    }

    public function getTimekitOpenSlotsByDate(array $collect,$icsURL=null)
    {
        $guzzleRequest = new Request();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/availability';
        $guzzleRequest->username_auth = null;
        
        $guzzleRequest->key_auth = $this->timkeit_dev_key; //todo: what is default
        $bodyGuzzle['resources'] = [$collect["resource_id"]];
     //$bodyGuzzle['project_id']='d775baff-b9bc-4752-8872-9555eaa7f5e6';
       $bodyGuzzle['mode'] = "roundrobin_prioritized";
       $bodyGuzzle['length'] = $collect["length"];
       $bodyGuzzle['timeslot_increments'] = $collect["timeslot_increments"];
       $bodyGuzzle['from'] = $collect["from"]; 
       $bodyGuzzle['to'] = $collect["to"]; 
        
        if(!is_null($icsURL))
        {
            $constraints=$this->getBlockedTimes($collect["resource_id"]);
             $bodyGuzzle['constraints'] = $constraints;
        }
        $bodyGuzzle['output_timezone'] = "America/Regina"; // TODO change to users Therapist Timezone
        //This buffer actually adds time before an appointemnt as well as after
       $bodyGuzzle['buffer']=$collect["buffer"];
        $guzzleRequest->body = $bodyGuzzle;
   
        return $guzzleRequest;
       // $responseGuzzle = $this->returnResponseJSON(config('enum.httpRequests.post'),$guzzleRequest);


        //return $responseGuzzle;
    }

    public function getTimekitOpenSlotsByDateWrapper(array $collect,$icsURL=null){

        $guzzleRequest = new Request();
        $guzzleRequest->url = Config::get('constants.urls.timekitapi') . '/availability';
        $guzzleRequest->username_auth = null;
        
        $guzzleRequest->key_auth = $this->timkeit_dev_key; //todo: what is default
        $bodyGuzzle['resources'] = [$collect["resource_id"]];
     //$bodyGuzzle['project_id']='d775baff-b9bc-4752-8872-9555eaa7f5e6';
       $bodyGuzzle['mode'] = "roundrobin_prioritized";
       $bodyGuzzle['length'] = $collect["length"];
       $bodyGuzzle['timeslot_increments'] = $collect["timeslot_increments"];
       $bodyGuzzle['from'] = $collect["from"]; 
       $bodyGuzzle['to'] = $collect["to"]; 
        
        if(!is_null($icsURL))
        {
            $constraints=$this->getBlockedTimes($collect["resource_id"]);
             $bodyGuzzle['constraints'] = $constraints;
        }
        $bodyGuzzle['output_timezone'] = "America/Regina"; // TODO change to users Therapist Timezone
        //This buffer actually adds time before an appointemnt as well as after
       $bodyGuzzle['buffer']=$collect["buffer"];
        $guzzleRequest->body = $bodyGuzzle;
   
       
        $responseGuzzle = $this->returnResponseJSON(config('enum.httpRequests.post'),$guzzleRequest);


     return $responseGuzzle;
    }


    public function sendPoolRequestToTimeKit( $collect){
        $responseGuzzle = $this->httpPools($collect);


        return $responseGuzzle;
    }

    public function cancelBookingTimekit($timekit_booking_id)
    {

        $request = new Request();
        $request->url =Config::get('constants.urls.timekitapi'). '/bookings/' .$timekit_booking_id.'/cancel';
        $request->username_auth = null;
        $request->key_auth = $this->timkeit_dev_key;
 
       
   
        $response = $this->returnResponseJSON(config('enum.httpRequests.httpPutWithoutBody'),$request);
        
        return $response;
       
    }

  public function deleteBookingTimekit($timekit_booking_id)
    {

        $request = new Request();
        $request->url =Config::get('constants.urls.timekitapi'). '/bookings/' .$timekit_booking_id;
        $request->username_auth = null;
        $request->key_auth = $this->timkeit_dev_key;
 
       
   
        $response = $this->returnResponseJSON(config('enum.httpRequests.delete'),$request);
        
        return $response;
       
    }


}
