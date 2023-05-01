<?php

use Illuminate\Database\Seeder;
 use Carbon\Carbon;
class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 DB::table('projects')->insert([
    	 	'id'=>1,
            'description' => '30 minutes',
            'slug' => '30 minutes',
            'length' => '30 minutes',
            'buffer'=>'15 minutes',
            'default'=>false,
            'mobile_name'=>'30 mins',
            'name'=>'Test Seed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'timekit_project_id'=>'604becad-fb70-436d-abe3-1e8b3bf23ef4'
        ]);
     
     DB::table('projects')->insert([
     		'id'=>2,
            'description' => '45 minutes',
            'slug' => '45-minutes',
            'length' => '45 minutes',
            'buffer'=>'15 minutes',
            'default'=>false,
            'mobile_name'=>'45 mins',
            'name'=>'45 minutes',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
             'timekit_project_id'=>'36d193f9-df92-484e-aadb-4811a34688db'
        ]);

        DB::table('projects')->insert([
        	'id'=>3,
            'description' => '60 minutes',
            'slug' => '60-minutes',
            'length' => '60 minutes',
            'buffer'=>'15 minutes',
            'default'=>true,
            'mobile_name'=>'60 mins',
            'name'=>'60 minutes',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
             'timekit_project_id'=>'b9f5d7ae-3e63-48e5-87eb-f2ef64727b11'
        ]);
           DB::table('projects')->insert([
           	'id'=>4,
            'description' => '75 minutes',
            'slug' => '75-minutes',
            'length' => '75 minutes',
            'buffer'=>'15 minutes',
            'default'=>false,
            'mobile_name'=>'75 mins',
            'name'=>'75 minutes',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
             'timekit_project_id'=>'09503eb1-23ea-4d55-8828-7ee776032ac0'
        ]);

            DB::table('projects')->insert([
            	'id'=>5,
            'description' => '90 minutes',
            'slug' => '90-minutes',
            'length' => '90 minutes',
            'buffer'=>'15 minutes',
            'default'=>false,
            'mobile_name'=>'90 mins',
            'name'=>'90 minutes',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
             'timekit_project_id'=>'7dfcd48d-fd0a-42b4-b5a3-293a5421ed2c'
        ]);

           DB::table('projects')->insert([
           	'id'=>6,
            'description' => '120 minutes',
            'slug' => '120-minutes',
            'length' => '120 minutes',
            'buffer'=>'15 minutes',
            'default'=>false,
            'mobile_name'=>'120 mins',
            'name'=>'120 minutes',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
             'timekit_project_id'=>'bbd845f8-d647-413f-9fea-96d3e0301867'
        ]);
    }
}



