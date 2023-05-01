<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use Faker\Generator as Faker;
use Carbon\Carbon;
$factory->define(Booking::class, function (Faker $faker) {
	 $Project = App\Project::all()->random()->id;
	 $User = App\User::all()->random()->id;
	 $bookables = [
        User::class,

    ]; 
    $bookableType = $faker->randomElement($bookables);
    return [
        'project_id'=>$Project,
        'when'=>Carbon::now(),
        'start'=>Carbon::now(),
        'end'=>Carbon::now(),
        'timekit_booking_id'=>'1',
        'bookable_id'=>$User,
       'bookable_type' =>$bookableType,
       'paid_by'=>'CA',


    ];
});
