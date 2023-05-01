<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\TherapistApi\v2\TherapistClientResource;
use App\Http\Resources\TherapistApi\v2\TherapistClientGuestResource;
use App\User;

use Illuminate\Support\Facades\Log;

class IntakeFormUnEncryptedDetailResource extends JsonResource
{

 
    public function toArray($request)
    {




        return [
           
            
        'name'=> $this->name,
        'address'=>  $this->address,
        'phone' =>   $this->phone,
        'birthdate' =>   $this->birthdate,
        'referred_by' =>   $this->referred_by,
        'physician_name' =>   $this->physician_name,
        'allergies' =>   $this->allergies,
        'sports_activities' =>   $this->sports_activities,
        'current_medications' =>   $this->current_medications,
        'medical_conditions' =>   $this->medical_conditions,
        'care' =>   $this->care,
        'surgery' =>   $this->surgery,
        'fractures' =>   $this->fractures,
        'illness' =>   $this->illness,
        'motor_workplace' =>   $this->motor_workplace,
        'tests' =>   $this->tests,
        'relieves' =>   $this->relieves,
        'aggravates' =>   $this->aggravates,
        'active'=>$this->active,
          'consent_date'=>Carbon::parse($this->pivot->created_at,'UTC')->isoFormat('MMM Do, YYYY'),
            
            ];
    }
}

