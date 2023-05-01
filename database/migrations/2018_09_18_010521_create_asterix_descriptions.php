<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsterixDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('servicecategories', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->text('smalldescription')->nullable();
             //varied prices will be used to figure out wether notifications need to have an assigned employee
        });    }

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
