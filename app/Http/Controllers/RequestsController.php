<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Manager;
use App\Locationtype;
use App\Location;
class RequestsController extends Controller
{
    //



    //
 public function index()
    {
        //
        $managers=Manager::all();
        var xs=
        return json_encode(["tokens"=>['access'=>['type'=>'header','value'=>'xs','expiresIn'=>'7'],'refresh'=>['type'=>'yellow','value'=>'again'],"user"=>['id'=>'55']);
         //
         //dd($employees);
        // $managers; 
        return  response()
            ->json(['managers' => $managers]);
        // return view('admin.business.partners',compact('managers'));
    }
}
