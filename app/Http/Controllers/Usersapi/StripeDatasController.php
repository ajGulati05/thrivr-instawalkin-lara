<?php

namespace App\Http\Controllers\Usersapi;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersApiNew\StripeDataResources;
use App\User;
use App\Stripedata;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\StripeTrait;
class StripeDatasController extends Controller
{
   //
	use StripeTrait;
 

   public function destroy(Request $request)
   {
      $user=Auth::user();
      Stripedata::where([['id', $request['stripedatas_id']],['user_id',$user->id]])->first()->delete();

      return response()->json(['error' => 'false', 'success' => true, 'code' => '201'], 201);
   }

  public function store(Request $request)
    {

        $card_token  = $request->card_token;
        $card_brand =  $request->card_brand;
        $card_last_four = $request->card_last_four;
        $native_pay = $request->native_pay;
        $card_id = $request->card_id;
        // $native_pay = $request->native_pay;

        $user_id = Auth::user()->id;
		 //Put default false to the other cards
        $otherStripeDatasCards =  Stripedata::withTrashed()->where('user_id', $user_id);
       	$countCards=$this->update($otherStripeDatasCards);
        //DO THE CUSTOMER VALIDATION
        if ($countCards > 0) {
            //call find function stripetrait
            $customerStripe = $this->_find($otherStripeDatasCards->first()->stripe_id);
        } else {

            $customerStripe = $this->_createCustomer(Auth::user()->email);
         
        }

        //attaching the card
        try {
            $card = $this->_createCard($customerStripe['id'], $card_token); //ask

            $stripeNewRegister = Stripedata::Create([
                "user_id" => $user_id,
                "stripe_id" => $customerStripe['id'],
                "card_brand" => $card_brand,
                "card_last_four" => $card_last_four,
                "card_token" => $card_id,
                "default_card" => true,
                "native_pay" => $native_pay
            ]);


            // return $stripeNewRegister;
            $newStripe = StripeData::where('id', $stripeNewRegister->id)->get();
            return StripeDataResources::collection($newStripe)->keyBy('id');
        } catch (Exception $exception) {
            Log::debug('Exception in stripe');
            Log::debug($exception);
            $exceptionNotificationRequest =  new Request();
            $dataNotificationToUser['user_id'] = Auth::user()->id;
            $dataNotificationToUser['error'] = $exception->getMessage();
            $dataNotificationToUser['card_id'] = $request->card_id;
            $exceptionNotificationRequest->data = $dataNotificationToUser;
            $exceptionNotificationRequest->reason = config('constants.notifications.notification_credit_card_error');
            $this->sentExceptionNotificationToSupport($exceptionNotificationRequest);

            return response()->json(['error' => true, 'message' => 'Cannot add card right now', 'code' => 401], 401);
        }
    }


       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($otherStripeDatasCards)
    {
        return 	$otherStripeDatasCards->update(['default_card'=>false]);
    }
   



}
