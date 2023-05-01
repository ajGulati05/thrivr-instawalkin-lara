<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserApiController extends Controller
{
    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

       // $this->middleware('profilecompleted');
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthUser()
    {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);

    }
    
}
