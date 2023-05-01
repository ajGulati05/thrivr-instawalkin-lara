<?php

namespace App\Http\Controllers\Usersapi\v2;

use App\UserGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersApi\v2\UserGuestResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class UserGuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $user=Auth::user();
        return response()->json(["data"=>UserGuestResource::collection($user->userGuests),"status"=>true]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
         $request->validate([
        'fullname'=>'required|string'
    ]);

        $user->userGuests()->create([
            'name'=>request('fullname'),
             'instauuid'=>(string) Str::orderedUuid()
        ]);
        return response()->json(["data"=>UserGuestResource::collection($user->userGuests),"status"=>true]);
    }
}
