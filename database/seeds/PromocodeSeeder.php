<?php

use App\Booking;
use App\Promocodehistory;
use App\User;
use Gabievi\Promocodes\Promocodes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromocodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // Creating promo code
        DB::table('promocodes')->insert([
            'code' => 'THRIVR1',
            'reward' => 10,
            'quantity' => null,
            'data'=>json_encode(['monthly'=>false,'description'=>null,'currency'=>'CAD']),
            'is_disposable'=>false,
            'expires_at'=>null
        ]);

        $users = User::whereHas('books')->get();

        foreach ($users as $user) {
            // applying the promo code
           $user->applyCode('THRIVR1');  
        }

    }
}
