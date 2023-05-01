<?php

namespace App\Http\Controllers;
use App\Booking;
use App\IntakeForm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\v2\IntakeFormsTrait; 
use App\Http\Traits\v2\CovidFormsTrait; 
use App\Http\Resources\UsersApi\v2\IntakeFormResource;
use App\Http\Resources\UsersApi\v2\IntakeFormDetailResource;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
class FormsController extends Controller
{
    use IntakeFormsTrait;
    use CovidFormsTrait;

    public function handleEmailFlow(Request $request){
        $booking=Booking::where('timekit_booking_id',request('param'))->first();
        $lessThan24=Carbon::now()->diffInHours(Carbon::parse($booking->start))>24?false:true;
      return response()->json(["data"=>['intake-form'=>$this->resolveIntakeForm($booking),"covid-form"=>$this->resolveCovidForm($booking),"lessThan24"=>$lessThan24],"status"=>true]);  
            
    }

  
}
