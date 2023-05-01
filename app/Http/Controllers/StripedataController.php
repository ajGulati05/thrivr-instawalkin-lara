<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Stripedata;
use JWTAuth;
use JWTAuthException;
use TokenExpiredException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Transactions;
use Stripe\{Stripe, Customer, Charge};

class StripedataController extends Controller
{
   //
   public function __construct()
   {
      // $this->middleware('jwt-auth');
   }

   public function store(Request $request)
   {

      $token = JWTAuth::getToken();
      $user = JWTAuth::toUser($token);

      $this->validate(request(), [
         'card_last_four' => 'required|min:4',
         'card_brand' => 'required|min:1',
         'card_token' => 'required|min:1'
      ]);

      Stripe::setApiKey(config('services.stripe.secret'));
      $customer = Customer::create(['email' => $user->email, "source" => $request['card_token']]);


      $stripedata = Stripedata::Create([
         'user_id' => $user->id,
         'stripe_id' => $customer->id,
         'card_last_four' => $request['card_last_four'],
         'card_brand' => $request['card_brand']
      ]);



      return response()->json(['error' => 'false', 'stripedata' => $stripedata, 'code' => '200'], 200);
   }
   public function destroy(Request $request)
   {
      Stripedata::where('stripe_id', $request['stripe_id'])->first()->delete();

      return response()->json(['error' => 'false', 'status' => '201', 'code' => '201'], 201);
   }

   public function addtip(Request $request)
   {

      Log::info('Creating tip for order: ' . request('order_id'));

      // Log::log('level', $request['tipamount']);
      try {

         $tipAmount = floatval(request('tipamount')) * 100;
         Stripe::setApiKey(config('services.stripe.secret'));
         $response   = Charge::create([
            'amount' => $tipAmount, 'currency' => 'cad', 'customer' => request('customer'),
            'statement_descriptor' => 'Instawalkin T',
            'metadata' => ['order_id' => request('order_id')]
         ]);


         //  $transaction=Transactions::where('id',request('order_id'))->first();
         $success = '0';
         if ($response->captured) {
            $success = '1';
         }
         //$captured=$response->
         Transactions::where('id', request('order_id'))->update([

            'tipamount' => request('tipamount'),
            'tipcaptured' => $success,
            'tipsuccess' => $success,
            'tipchargeid' => $response->id,
            'tipdate_at' => Carbon::now(),
            'transactionclosed' => $success
         ]);

         return response()->json(['error' => 'false', 'status' => '201', 'code' => '201', 'message' => 'Success'], 201);
      } catch (Exception $e) {
         return response()->json(['error' => 'true', 'status' => '300', 'code' => '300', 'message' => $e], 300);
      }
   }
}
