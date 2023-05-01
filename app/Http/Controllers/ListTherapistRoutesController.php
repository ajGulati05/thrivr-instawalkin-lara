<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use App\ManagerProfile;
use App\Http\Resources\SiteMapResource;
class ListTherapistRoutesController extends Controller
{
    //

    public function index(){

        $nonTherapistLinks=collect([
    ['site' => ''],
    ['site' => 'contact-us'],
    ['site' => 'become-a-partner'],
    ['site' => 'become-a-partner#pricing'],
    ['site' => 'become-a-partner#faq'],
    ['site' => '#faq'],
    ['site'=>'login'],
    ['site'=>'signup'],
    ['site'=>'massage-therapists/Saskatoon']
 ]);

        $siteMapSource=SiteMapResource::collection(Manager::active()->with('profiles')->get());
        $merged = $siteMapSource->merge($nonTherapistLinks);
    		return response()->json(["data"=>$merged,"status"=>true]);

    }
}
