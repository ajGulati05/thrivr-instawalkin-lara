<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EndorsementReview extends Pivot
{
    public function reviews(){
    	return $this->belongsTo('App\Review','review_id','id');
    }

     public function verifiedReviews(){
        return $this->reviews();
    }

     public function unverifiedReviews(){
        return $this->reviews();
    }
    public function values(){
    	return $this->belongsTo('App\Endorsement');
    }

      public function endorsementreview()
    {
        return $this->hasManyThrough('App\EndorsementReview', 'App\Endorsement');
    }
}