<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLocationsLocaleTypeofservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::create('featurecodes', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
         
        });
          Schema::table('locations', function (Blueprint $table) {
                $table->string('locale')->default('America/Regina');
                $table->string('features')->default('A')->references('code')->on('featurecodes');
                $table->string('googleraiting')->default('0');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featurecodes');
    }
}
