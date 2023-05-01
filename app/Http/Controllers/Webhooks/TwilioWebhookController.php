<?php

namespace App\Http\Controllers\Usersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Guest;
//TODO: TAKE AS REFERENCE THE VENDOR_OVERRIDE AUTHENTICATE USERS TRAIT

class TwilioWebhookController extends Controller
{

   public function unsubscribe( Request $request){
    Log::debug($request);
   }
}
