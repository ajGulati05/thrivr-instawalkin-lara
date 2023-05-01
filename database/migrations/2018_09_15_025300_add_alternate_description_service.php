<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlternateDescriptionService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('services', function (Blueprint $table) {
               
              $table->text('altdescription')->nullable();
                
        });

          Schema::table('locations', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->boolean('hours')->default(1);
             //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->boolean('variedprices')->default(0);
        });


             Schema::table('servicecategories', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->integer('ordernumber')->default(1);
             //varied prices will be used to figure out wether notifications need to have an assigned employee
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
