<?php

namespace App\Http\Controllers\Usersapi\v2;
use App\Manager;
use App\IntakeForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\v2\IntakeFormsTrait; 
use App\Http\Resources\UsersApi\v2\IntakeFormResource;
use App\Http\Resources\UsersApi\v2\IntakeFormDetailResource;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\IntakeFormRequest;
class IntakeFormController extends Controller
{
    use IntakeFormsTrait;

    public function list(){
        $user=Auth::user();
        $intakeForm=$this->getAllCurrentActiveIntakeForm($user);

        return response()->json(['data'=>IntakeFormResource::collection($intakeForm),"status"=>true]);
    }
    

    public function detail(IntakeForm $intakeForm){
      
        return response()->json(['data'=> new IntakeFormDetailResource($intakeForm),"status"=>true]);
    }

    public function store(IntakeFormRequest $request)
    {   

      
         $user=Auth::user();
         
         $intakeform= $this->storeIntakeForm($user,$request);
         return response()->json(['data'=>new IntakeFormResource($intakeform),"status"=>true]);
    }

  
}
