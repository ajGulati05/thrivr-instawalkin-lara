<?php

namespace App\Http\Controllers\Usersapi\v2;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersApi\v2\CreditCardResource;
use App\User;
use App\Stripedata;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\v2\StripeTraitV2;
use Exception;

class CreditCardController extends Controller
{
   //
	use StripeTraitV2;
         /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

       $paymentoptions =StripeData::where('user_id',Auth::user()->id)->get();
       return response()->json(["data"=>CreditCardResource::collection($paymentoptions),"status"=>true],200);
         

    }



   public function destroy(Stripedata $card)
   {


      if ($this->authorize('destroy', $card)) {
      $card->delete();

      return response()->json([ 'status' => true, 'message'=>'Your card has been deleted'], 200);
  }
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
       	$countCards=$this->setCardToNotBeDefault($otherStripeDatasCards);
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
            // set the new added card as default on stripe
            $this->_update($customerStripe['id'],['default_source'=>$card['id']]);

            // return $stripeNewRegister;
            $newStripe = StripeData::where('id', $stripeNewRegister->id)->get();
               return response()->json(["data"=>CreditCardResource::collection($newStripe),"status"=>true],200);
           
        } catch (Exception $exception) {
    
    
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
    public function setCardToDefault(Stripedata $card)
    {
          if ($this->authorize('default', $card))
           {  
               Stripedata::withTrashed()->where('user_id', Auth::id())->update(['default_card'=>false]);
                $card->update(['default_card'=>true]);

                // setting card as default on stripe
                try{
                    $this->_update($card->stripe_id,['default_source'=>$card->card_token]);
                }catch(Exception $exception){
                    LOg::critical("Failed setting card with stripedata id:{$card->id} as defualt");
                }
                
               return response()->json([ 'status' => true, 'message'=>'Card updated.'], 200);
            }

    }
   
       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setCardToNotBeDefault($otherStripeDatasCards)
    {   
        return  $otherStripeDatasCards->update(['default_card'=>false]);
    }
   


}
