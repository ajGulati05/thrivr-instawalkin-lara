<?php

use Illuminate\Database\Seeder;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('taxes')->insert([
           	'taxcode'=>'SK GST 5',
            'taxpercent' => '5',
           
          
        ]);
           DB::table('taxes')->insert([
           	'taxcode'=>'No Tax',
            'taxpercent' => '0',
           
          
        ]);



          DB::table('projectpricings_taxes')->insert([
           	'project_pricing_id'=>'1',
            'tax_id' => '1',
           
          
        ]);
            DB::table('projectpricings_taxes')->insert([
           	'project_pricing_id'=>'2',
            'tax_id' => '1',
           
          
        ]);
              DB::table('projectpricings_taxes')->insert([
           	'project_pricing_id'=>'3',
            'tax_id' => '1',
           
          
        ]);
                DB::table('projectpricings_taxes')->insert([
           	'project_pricing_id'=>'4',
            'tax_id' => '1',
           
          
        ]);
                  DB::table('projectpricings_taxes')->insert([
           	'project_pricing_id'=>'5',
            'tax_id' => '1',
           
          
        ]);
                    DB::table('projectpricings_taxes')->insert([
           	'project_pricing_id'=>'6',
            'tax_id' => '1',
           
          
        ]);
    }
}




