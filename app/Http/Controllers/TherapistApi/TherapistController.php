<?php

namespace App\Http\Controllers\TherapistApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Manager;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\TherapistResource;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TherapistApi\UserInformationResource; 
class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $therapist=Auth::user()->load('manager_profiles');
    return new TherapistResource($therapist);

    }
/**
     * Display a listing of the resource.return (new OfficeResource($office))
        ->response()
        ->setStatusCode(201);
     *
     * @return \Illuminate\Http\Response
     */
    public function block(Request $request)
    {  
        $therapist=Auth::user();
        $user=User::where('id',request('user_id'))->first();
        $therapist->blockedUsers()->attach(request('user_id'));
        return  response()->json(new UserInformationResource($user,$therapist),201);
     
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unblock(Request $request)
    {  
        $therapist=Auth::user();
        $user=User::where('id',request('user_id'))->first();
        $therapist->blockedUsers()->detach(request('user_id'));
         return  response()->json(new UserInformationResource($user,$therapist),201);
    }
}
