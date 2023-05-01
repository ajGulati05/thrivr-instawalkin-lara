<?php

namespace App\Http\Resources\CommonResources\v2;


use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

use \Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CovidFormUnEncryptedDetailResource extends JsonResource
{

 
    public function toArray($request)
    {

//       $newEncrypter = new \Illuminate\Encryption\Encrypter(config('app.encrypt_key','AES-256-CBC');
      


        return [
           
                
        'name'=> $this->name,
      'testing'=> $this->testing,
        'symptoms' =>  $this->symptoms,
        'exposure' =>  $this->exposure,
        'travel' =>   $this->travel,
        'precautions' =>   $this->precautions,
        'contact' =>   $this->contact,
        'actions' => $this->actions,
        'signed_date'=>Carbon::parse(optional($this->pivot)->created_at, 'UTC')->isoFormat('MMM Do, YYYY')
    
            
            ];
    }
}


  