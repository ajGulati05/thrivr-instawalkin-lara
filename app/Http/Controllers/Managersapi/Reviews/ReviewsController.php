<?php

namespace App\Http\Controllers\Managersapi\Reviews;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\v2\TherapistReviewResource; 
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use App\Queries\Filters\FuzzyFilter;

class ReviewsController extends Controller
{
      public function list(Request $request)
    {


      
        $reviews=Auth::user()->reviews()->getQuery();
 
       $builtQuery=QueryBuilder::for($reviews)
        ->allowedFilters(AllowedFilter::custom('search',new FuzzyFilter('comment')))
        ->defaultSorts('-created_at')
        ->allowedSorts(['id','verified','created_at'])
        ->paginate()
        ->appends(request()->query());

        return TherapistReviewResource::collection($builtQuery);
    
        
    }

  
}
