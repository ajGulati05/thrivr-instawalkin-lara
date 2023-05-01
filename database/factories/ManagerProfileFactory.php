<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Managerprofile;
use Faker\Generator as Faker;

$factory->define(Managerprofile::class, function (Faker $faker) {
    return [
        'address'=>$faker->streetAddress,
        'phone'=>$faker->e164PhoneNumber,
        'city'=>'Saskatoon',
        'postal_code'=>'S7M0H7',
        'province'=>'SK',
        'latitude'=>$faker->latitude(52.128535,52.136122),
        'longitude'=>$faker->longitude(-106.635787,-106.634413),
      	'tag_line'=>$faker->text(150),
        'parking'=>$faker->randomElement(array (true,false)),
        'address_description'=>$faker->sentence(5),
        'parking_description'=>$faker->sentence(5),
        'about'=>$faker->text(500),
        'extra_information'=>$faker->text(500),
        'direct_billing'=>$faker->randomElement(array (true,false)),
        'code'=>'B'
    ];
});

