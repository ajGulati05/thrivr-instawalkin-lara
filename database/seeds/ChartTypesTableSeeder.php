<?php

use Illuminate\Database\Seeder;

class ChartTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chart_types')->insert([
            'code'=>'SOAP',
            'description' => 'SOAP NOTES',
         ]);
         DB::table('chart_types')->insert([
            'code'=>'CC',
            'description' => 'Chief Complaint',
         ]);
          DB::table('chart_types')->insert([
            'code'=>'BC',
            'description' => 'Body Chart',
         ]);
    }
}
