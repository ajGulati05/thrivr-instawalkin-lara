<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use App\Review;
use App\User;
use App\Manager;
use App\Booking;
use App\Endorsement;
use Illuminate\Support\Facades\Log;
//Unverified User Comments and endorsements
$factory->define(Review::class,function (Faker $faker) {
	 // Add new noteables here as we make them
  
   
    $reviewables = [
        User::class,

    ]; // Add new noteables here as we make them
    $reviewableType = $faker->randomElement($reviewables);
    $reviewable = User::all()->random()->id;
   return [
        'comment' => $faker->paragraph,
        'score' => $faker->numberBetween(0,5),
        'manager_id'=>Manager::all()->random()->id,
        'reviewable_type' => $reviewableType,
        'reviewable_id' => $reviewable,
         'verified'=>$faker->randomElement(array (true,false)),
         'parent_id'=>null
    ];
});


//Verified User Comments and endorsements
$factory->state(Review::class, 'verifieds',function (Faker $faker,$params)  {
    $reviewables = [
        User::class,

    ]; // Add new noteables here as we make them
    $reviewableType = $faker->randomElement($reviewables);

   return [
        'comment' => $faker->paragraph,
        'score' => $faker->numberBetween(0,5),
        'manager_id'=>$params['manager_id'],
        'reviewable_type' => $reviewableType,
        'reviewable_id' => $params['reviewable_id'],
        'verified'=>true,
        'booking_id'=>$params['booking_id']
    ];





});

$factory->afterCreating(App\Review::class, function ($review, $faker) {
      Log::debug('$review'.$review->id); 
               $endorsements1=Endorsement::where('id','<=',3)->get()->random();
               $endorsements2=Endorsement::where('id','>=',4)->get()->random();
              $review->endorsements()->attach([$endorsements1->id,$endorsements2->id]);
});

//Verified User Comments and endorsements
$factory->state(Review::class, 'replies_manager',function (Faker $faker,$params)  {
    $reviewables = [
        Manager::class,

    ]; // Add new noteables here as we make them
    $reviewableType = $faker->randomElement($reviewables);
   $reviews=Review::where('parent_id',0)->get();

   return [
        'comment' => $faker->paragraph,
        'reviewable_type' => $reviewableType,
        'reviewable_id' => $params['reviewable_id'],
        'parent_id'=>$params['parent_id']
    ];





});


//Verified User Comments and endorsements
$factory->state(Review::class, 'replies_user',function (Faker $faker,$params)  {
    $reviewables = [
        User::class

    ]; // Add new noteables here as we make them
    $reviewableType = $faker->randomElement($reviewables);

    $randomUser=User::all()->random();

   return [
        'comment' => $faker->paragraph,
        'reviewable_type' => $reviewableType,
        'reviewable_id' => $params['reviewable_id'],
        'parent_id'=>$params['parent_id']
    ];





});

