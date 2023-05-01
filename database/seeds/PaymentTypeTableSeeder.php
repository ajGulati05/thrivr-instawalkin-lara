<?php

use Illuminate\Database\Seeder;


class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_types')->insert([
           	'code'=>'DB',
            'description' => 'Direct Billing'
            
          
        ]);
         DB::table('payment_types')->insert([
           	'code'=>'SQ',
            'description' => 'Square'
            
          
        ]);
          DB::table('payment_types')->insert([
           	'code'=>'CA',
            'description' => 'Cash'
            
          
        ]);
         
    }
}
