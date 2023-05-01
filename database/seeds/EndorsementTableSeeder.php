<?php

use Illuminate\Database\Seeder;

class EndorsementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('endorsements')->insert([
           	'name'=>'Pressure Pro',
            'description' => 'Great understanding of depth and pressure.',
            'path' => 'endorsements/Pressure-Pro.svg',
          	'active'=>true
        ]);
           DB::table('endorsements')->insert([
           	'name'=>'Master Communicator',
            'description' => 'Communicates style effectively and is attentive to client needs.',
            'path' => 'endorsements/master-communicator.svg',
          	'active'=>true
        ]);
            DB::table('endorsements')->insert([
           	'name'=>'Soothing Environment',
            'description' => 'Gentle calm (a soothing feeling to the environment).',
            'path' => 'endorsements/Soothing-Environment.svg',
          	'active'=>true
        ]);
            DB::table('endorsements')->insert([
           	'name'=>'Tranquil Space',
            'description' => 'Free from noise or disturbance; calm..',
            'path' => 'endorsements/Tranquil-Space.svg',
          	'active'=>true
        ]);

           DB::table('endorsements')->insert([
           	'name'=>'Fresh and Clean',
            'description' => 'Space and massage area are neat and tidy.',
            'path' => 'endorsements/fresh-clean.svg',
          	'active'=>true
        ]);

            DB::table('endorsements')->insert([
           	'name'=>'Prompt and Polite',
            'description' => 'The RMT is Prompt; great utilization of time and consideration for the clients well-being.',
            'path' => 'endorsements/Prompt-Polite.svg',
          	'active'=>true
        ]);
    }
}

