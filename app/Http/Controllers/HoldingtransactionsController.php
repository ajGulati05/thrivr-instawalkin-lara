<?php

namespace App\Http\Controllers;
use App\Location;
use App\Holdingtransactions;
use Illuminate\Http\Request;
use App\Transactions;
use App\Taxes;
use App\UserCredits;
use App\CorporationpromoUser;
use Carbon\Carbon;
use App\Promocodehistory;
use App\PromocodeUser;
use Gabievi\Promocodes\Models\Promocode;
use JWTAuth;
use JWTAuthException;
use TokenExpiredException;
use App\User;
 use App\Http\Resources\HoldingTransactionsResource;
  use App\Http\Resources\UsersApi\PromocodehistoryResource;
class HoldingtransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holdingtransactions=Holdingtransactions::all();
    
        return view('admin.transactions.holding.index',compact('holdingtransactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Holdingtransactions  $holdingtransactions
     * @return \Illuminate\Http\Response
     */
    public function show(Holdingtransactions $holdingtransactions)
    {   
        //change this to only show where it matches massage locationtype
        $locations=Location::all();
        return view('admin.transactions.holding.edit',compact('locations','holdingtransactions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holdingtransactions  $holdingtransactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Holdingtransactions $holdingtransactions)
    {
        //
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holdingtransactions  $holdingtransactions
     * @return \Illuminate\Http\Response
     */
    public function getUnreadHoldingTransactions (Request $request)
    {

      $token = null;
        try {
            $token = JWTAuth::getToken();
           
            $user = JWTAuth::toUser($token);
            $holdingtransactions=$user->holdingtransactions->where('statuscode','W');
          
            return HoldingTransactionsResource::collection($holdingtransactions)->keyBy('id');  
          
        } catch(TokenExpiredException $e) {
    //token cannot be refreshed, user needs to login again
    
               return response()->json(['error' =>'true','message'=>'Need to Login Again','code'=>'401'],401);
   
        }
      
        
     
    }
public function getcorp(){
    $corporationpromouser= Corporationpromouser::with('corporationpromos')->where('validated','0')->where('users_id',39);
       dd($corporationpromouser->exists());
}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holdingtransactions  $holdingtransactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holdingtransactions $holdingtransactions)
    {
        
        /// update holding trasnactions table set it to approved and add a comment
    
       //make service id nullable.  return redirect()->route('admin.services.create',['locationid'=>$locationid]);


        $approved=true;
         $statuscode='A';

        if(request('btn')=='declined' ) {
        //if declined set approved to false
            $approved=false;
            $statuscode='D';
    }
        elseif(request('btn')=='accepted')
        {
           $approved=true;
            $statuscode='A';
        }

      

       $holdingtransactions->update([

            'approved'=>$approved,
             'statuscode'=>$statuscode,
            'comment'=>request('comment')
            ]);



if($approved){
        $x=request('servicedate').' '.request('service_starttime');
       
         $arrival_at=new Carbon($x,'America/Regina');
         $service=$holdingtransactions->servicecategories->services->where('location_id',request('location')[0])->first();
         $price=$holdingtransactions->instaprices->price;
      
       $taxAmount=number_format((float)($price*$service->taxes->sum('taxpercent')/100), 2, '.', '');
     
        $transactions = new Transactions;
        $transactions->user_id = $holdingtransactions->user_id;
        $transactions->location_id = request('location')[0]; 
        $transactions->service_id = $service->id;
        $transactions->serviceamount=$price; // 
        $transactions->taxamount=$taxAmount;//calculate tax amount
        $transactions->service_response_code='A'; //calculate tax amount
        $transactions->servicecategory_id=$holdingtransactions->servicecategories_id;
        $transactions->arrival_at=$arrival_at->setTimezone('UTC');
        $transactions->holdingtransactions_id=$holdingtransactions->id;

        $transactions->newaddress=request('newaddress');
        $transactions->newpostalcode=request('newpostalcode');
        $transactions->newlat=request('newlat');
        $transactions->newlong=request('newlong');
        $transactions->newcity=request('newcity');
        $transactions->newprovince=request('newprovince');
        $transactions->newdescription=request('newdescription');
       


        //figure out if the user is a corporation member
       $corporationpromouser= Corporationpromouser::with('corporationpromos')->where('validated','1')->where('users_id',$holdingtransactions->user_id);
        
       if($corporationpromouser->exists())
       {
          
            $transactions->discount_type='CO';
            $couponAmountCalc=number_format((float)($price*($corporationpromouser->first()->corporationpromos->percent)/100), 2, '.', '');
            $transactions->coupon_amount_calc=$couponAmountCalc;
      }
       else{
            //corp account does not exists
            //check if credit exists

             $usercredit= UserCredits::greaterthanzero()->where('user_id',$holdingtransactions->user_id);
              if($usercredit->exists())
              {
               //nothing needs to be done
                // if credit is greater than totalAmount then credit left needs to be updated
            
                $transactions->discount_type='C';
                //get the coupon amount calc
                $transactions->coupon_amount_calc=$usercredit->first()->amount;
                //the total amount of the service
                $totalAmount=$price+$taxAmount;
                //amount left eg serive is 60 and credit is 100 = -40
                //service is 100 credit is 60 = 40
                //serivce is 100 credit is 100= 0
                $creditleft=$totalAmount-$usercredit->first()->amount;
                 $checkAmount=$totalAmount-$usercredit->first()->amount;
                 
               if($creditleft==0){
                     $transactions->coupon_amount_calc=$totalAmount;
                    $creditleft=0;
               }
               else if ($creditleft>0){
                    $transactions->coupon_amount_calc=$usercredit->first()->amount;
                    $creditleft=0;
               }
               else{
                        $transactions->coupon_amount_calc=$totalAmount;
                        $creditleft=$usercredit->first()->amount-$totalAmount;
               }
                 
                    $this->updateCreditTables($holdingtransactions->user_id,$creditleft);
              }


            else if ($holdingtransactions->discount_type=='P'){
                     $transactions->discount_type='P';   
                     $transactions->coupon_amount_calc=$holdingtransactions->promoamount;
                 //check if there is a promo code that could be applied
                    

                    }
             else{
                        $transactions->discount_type=null;   
                     $transactions->coupon_amount_calc=$holdingtransactions->promoamount;
             }       


       }
       $transactions->chargeid=0;
    $transactions->save();
        
       if($transactions->discount_type=='P')
       {
        $this->updatePromoTables($holdingtransactions->user_id,$holdingtransactions->promocode, $transactions->id,$holdingtransactions->promoamount);
       }
    }
       //send notifications to both user and manager


    }
//update usercredits set amount=? where id=?', [payload.creditamount, payload.usercreditsid])



       
public function updateCreditTables($userid,$amount){
    

    $usercredits= UserCredits::where('user_id',$userid);
    $usercredits->update([  'amount'=>$amount  ]);    

}   

//insert into promocodehistorys (user_id,promocode_id,transaction_id) VALUES(?,?,?)', [payload.userdiscount_id, payload.discount_id,payload.order_id
//update promocode_user set leftamount= leftamount+? where promocode_id=? and user_id=?', [payload.coupon_amount_calc,payload.discount_id,payload.userdiscount_id]
public function updatePromoTables($userid,$promocode,$transactionid,$amount){
    

    $promocodemodel=Promocode::where('code',$promocode)->first();
  
    $promocodehistory=Promocodehistory::Create([
        'user_id'=>$userid,
        'promocode_id'=>$promocodemodel->id,
        'transaction_id'=>$transactionid,
        'used_at'=>Carbon::now()
    ]);

   $promocodeuser= PromocodeUser::where('user_id',$userid)
   ->where('promocode_id',$promocodemodel->id)->first();
    
   $lamount=$promocodeuser->leftamount - $amount;
   
   $promocodeuser->update(['leftamount'=>$lamount]);




}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holdingtransactions  $holdingtransactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holdingtransactions $holdingtransactions)
    {
        //
    }
}
