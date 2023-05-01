<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ManagerLicense;
use Faker\Generator as Faker;
use Carbon\Carbon;
$factory->define(ManagerLicense::class, function (Faker $faker) {
    return [
        'license_number'=>'test1234',
        'validated_at'=>Carbon::now(),
        'expired_at'=>Carbon::now()->addDays(365)
    ];
});
