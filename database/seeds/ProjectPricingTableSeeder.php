<?php

use Illuminate\Database\Seeder;
 use Carbon\Carbon;
class ProjectPricingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
             DB::table('project_pricings')->insert([
           	'project_id'=>1,
            'start_date' => Carbon::now(),
            'amount' => 42.86,
          
        ]);


               DB::table('project_pricings')->insert([
           	'project_id'=>2,
            'start_date' => Carbon::now(),
            'amount' => 57.14
          
        ]);
                 DB::table('project_pricings')->insert([
           	'project_id'=>3,
            'start_date' => Carbon::now(),
            'amount' =>71.43
          
        ]);
                       DB::table('project_pricings')->insert([
           	'project_id'=>4,
            'start_date' => Carbon::now(),
            'amount' =>90.48
          
        ]);
                             DB::table('project_pricings')->insert([
           	'project_id'=>5,
            'start_date' => Carbon::now(),
            'amount' =>108.52
          
        ]);
                                   DB::table('project_pricings')->insert([
           	'project_id'=>6,
            'start_date' => Carbon::now(),
            'amount' =>147.62
          
        ]);
    }
}

