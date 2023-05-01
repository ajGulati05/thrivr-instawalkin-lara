<?php

namespace App\Http\Resources\TherapistApi\v2\Charts;


use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TherapistChartDetailResource extends JsonResource
{

protected $manager,$timezone;
 
    public function toArray($request)
    {
        $this->manager=Auth::user();
       $this->timezone=$this->manager->timezone;

//       $newEncrypter = new \Illuminate\Encryption\Encrypter(config('app.encrypt_key','AES-256-CBC');
      


        return [
           
        "id"=>$this->id,
        "chart_type"=> $this->chart_types_code,
        "chart_type_description"=>optional($this->chartType)->description,
        "locked"=>$this->locked,
        "children"=>self::collection($this->whenLoaded('children')),
        "created_at"=>Carbon::parse($this->created_at, 'UTC')->isoFormat('MMM Do, YYYY'),
        'data'=> $this->data
       
    
            
            ];
    }
}


  