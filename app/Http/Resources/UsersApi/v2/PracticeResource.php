<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;



class PracticeResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           "name"=>$this->short_description,
            "long_description"=>$this->long_description,

            ];
    }
}




 