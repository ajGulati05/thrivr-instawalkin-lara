<?php

namespace App\Http\Controllers\Usersapi\v2;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UsersApi\v2\ReviewResource;
use App\Manager;
use App\Support\Collection;
use App\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Endorsement;
use App\Http\Resources\UsersApi\v2\UserEndorsementResource;

class ReviewController extends Controller
{


    public function index(Manager $manager,$itemcount,$sort){

        //reviews can be of two types - verified and unverified

       $reviews=$manager->reviews()->sort($sort)->get();
       $collection = (new Collection(ReviewResource::collection($reviews)))->paginate($itemcount);

         return response()->json(["data"=> $collection

         ,"status"=>true],200);
    }



   public function createReviewForTherapist(Request $request, Manager $manager){

///all reviews for a user give me a count where manager_id=x


   		$user=Auth::user();
   		$verified=0;


   	if( $user->load('reviews')->reviews->where('manager_id',$manager->id)->count()>0)
   		{
   			return response()->json(["message"=>"Sorry, you already have written a review for the therapist.","errors"=>"Sorry, you already have written a review for the therapist.","status"=>false],422);
   		}


   		if( $user->books()->where('manager_id',$manager->id)->get()->isNotEmpty())
   		{
   			$verified=1;
   		}

   		 $request->validate([
            'score' => 'required|numeric|between:1,5',
            'comment' => 'required|string|between:10,500',
            'endorsementKey' => 'sometimes|required|string|min:1|max:5|nullable'

        ]);

   		 $review=$user->reviews()->create([
   		 	'comment'=>request('comment'),
   		 	'score'=>request('score'),
   		 	'manager_id'=>$manager->id,
   		 	'verified'=>$verified //TODO verified if booking relation exists.
   		 ]);


      $endorsementCollection=collect();
   		if(!empty(request('endorsementKey')))
		{
   			$endorsementIds=explode(',', request('endorsementKey'));
   			$endorsement= $review->endorsements()->attach($endorsementIds);
        $endorsementCollection=Endorsement::endorsementCountForUsers($manager);
   		}


   		return response()->json(["data"=>["review"=>new ReviewResource($review),"review_count"=>$manager->reviewCount(),"endorsements"=>UserEndorsementResource::collection($endorsementCollection)],"status"=>true],200);
   }


    public function createReviewForBooking(Request $request, Booking $booking){
$user=Auth::user();
   $manager=Manager::find($booking->manager_id);


   		if( $booking->reviews()->count()>0)
   		{
   			return response()->json(["message"=>"Sorry, you already have written a review for this booking.","errors"=>"Sorry, you already have written a review for this booking.","status"=>false],422);
   		}
   		 $request->validate([
            'score' => 'required|numeric|between:1,5',
            'comment' => 'required|string|between:10,500',
            'endorsementKey' => 'sometimes|required|string|min:1|max:5|nullable',
            'feedback'=>'sometimes|required|string|between:10,500|nullable',

        ]);

   		 $review=$user->reviews()->create([
   		 	'comment'=>request('comment'),
   		 	'score'=>request('score'),
   		 	'booking_id'=>$booking->id,
   		 	'manager_id'=>$booking->manager_id,
   		 	'verified'=>1
   		 ]);
   		  $endorsementCollection=collect();
   		if(!empty(request('endorsementKey')))
		{
   			$endorsementIds=explode(',', request('endorsementKey'));
   			$endorsement= $review->endorsements()->attach($endorsementIds);

         $endorsementCollection=Endorsement::endorsementCountForUsers($manager);
   		}

    if(!empty(request('feedback')))
    {

        $feedback= $review->personalFeedback()->create(['user_comment'=>request('feedback')]);


      }

   			return response()->json(["data"=>["review"=>new ReviewResource($review),"review_count"=>$manager->reviewCount(),"endorsement"=>UserEndorsementResource::collection($endorsementCollection)],"status"=>true],200);
   }

}
