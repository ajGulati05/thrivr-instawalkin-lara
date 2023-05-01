<?php

namespace App\Http\Controllers\Managersapi\Clients;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\v2\TherapistClientResource;
use App\User;

class BlockClientController extends Controller
{
    public function block(Request $request){
          $manager=Auth::user();


			if(Request::exists('user')&&Request::has('user'))
{
   $user= $manager->clients()->updateExistingPivot(request('user'),['blocked'=>1,'reason'=>request('reason')]);
$userResource=new TherapistClientResource($manager->clients()->where('user_id',request('user')->id)->first());
    return response()->json(["data"=>$userResource,"status"=>true]);
}


     
    }   


  public function unblock(Request $request){
               $manager=Auth::user();


			if(Request::exists('user')&&Request::has('user'))
		{
   			$user= $manager->clients()->updateExistingPivot(request('user'),['blocked'=>0]);
			$userResource=new TherapistClientResource($manager->clients()->where('user_id',request('user')->id)->first());
    		return response()->json(["data"=>$userResource,"status"=>true]);
}


     
    }   
 




}
