<?php

namespace App\Http\Controllers\Usersapi\v2;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UsersApi\v2\UserEndorsementResource ; 
use App\Manager;
use App\Support\Collection;
use App\Endorsement;
class UserEndorsementController extends Controller
{
   

    public function index(Manager $manager){


 $endorsements=Endorsement::endorsementCountForUsers($manager);

return response()->json(['data'=>UserEndorsementResource::collection($endorsements),'status'=>true],200);
}
}

