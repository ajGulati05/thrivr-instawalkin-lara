<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Manager;
use App\Gender;
use Faker\Generator as Faker;

$factory->define(Manager::class, function (Faker $faker) {
       $gender=Gender::all()->random();
   
   return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender'=>$gender->code,
    	'profile_photo'=>'managers/vq53N7TtxI2rp0YWJnlkt3IE8jTUmuqzHUD6CPI5.jpeg',
    	'timezone'=>'America/Regina',
    	'business_name'=>$faker->company,
    	'product_code'=>'A',
    	'slug'=>$faker->slug,];
     
});

$factory->state(Manager::class,'booking', function (Faker $faker) {
   $gender=Gender::all()->random();
   return [
       'timekit_resource_id'=>$faker->unique()->randomElement(array('66390464-8467-4f8b-aeb2-33ca82977d41','69505849-e39c-427a-a4f1-7a6bd0a17e73','31875153-dd9a-4da6-b71e-ea402179cd26','8371840e-5786-4fcc-84b6-5d2f870e6750','08d60951-8807-469e-bce9-22dbcacb73a1','fc910af2-d76c-4274-a6ab-dc8faebb597d','f7236bf4-4240-48c9-a97a-38ad36913450','b82d2baf-c734-412a-99aa-32e77f45d911','938b72a9-e807-478a-bbaa-1bf25a18452e','38047c34-0ba3-45d0-b202-f1f32e31b943','2b460efd-cb9b-418a-8745-066805cc3cd7','a5e4687d-f345-4482-9592-da81a5c92138'))
       
    ];
 


});
//Verified User Comments and endorsements
$factory->state(Manager::class,'listing', function (Faker $faker) {
   $gender=Gender::all()->random();
   return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'gender'=>$gender->code,
    	'profile_photo'=>'managers/vq53N7TtxI2rp0YWJnlkt3IE8jTUmuqzHUD6CPI5.jpeg',
    	'timezone'=>'America/Regina',
    	'business_name'=>$faker->name,
    	'product_code'=>'L',
    	'slug'=>$faker->slug
    ];


});
