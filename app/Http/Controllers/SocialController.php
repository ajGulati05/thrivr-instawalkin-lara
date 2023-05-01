<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    //

    public function sendSms(Request $request){
     
        return redirect("sms:?&body=Your%20friend%20{$request->name},%20thought%20you%20could%20use%20a%20little%20rest%20and%20relaxation%20so%20they%20sent%20you%20$10%20off%20toward%20a%20relaxing%20massage%20with%20Thrivr!%20Use%20this%20link%20to%20https://thrivr.ca/signup?referral={$request->refcode}");
    }
}
