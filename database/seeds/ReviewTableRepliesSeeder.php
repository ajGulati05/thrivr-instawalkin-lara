<?php

use Illuminate\Database\Seeder;
use App\Review;
class ReviewTableRepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	    $reviews=Review::where('parent_id',0)->get();
    	    foreach($reviews as $review)
           {  factory(Review::class)->states('replies_user')->create(['parent_id'=>$review->id,'reviewable_id'=>$review->reviewable_id]);
			 factory(Review::class)->states('replies_manager')->create(['parent_id'=>$review->id,'reviewable_id'=>$review->reviewable_id]);


            factory(Review::class)->states('replies_user')->create(['parent_id'=>$review->id,'reviewable_id'=>$review->reviewable_id]);
        }
    }
}

       