<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultiServiceLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_service_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->references('id')->on('locations');
            $table->integer('locationtype_id')->references('id')->on('locationtypes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multi_service_locations');
    }
}
