<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPivotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tax_services');
        Schema::dropIfExists('multi_service_locations');
        Schema::create('service_taxes', function (Blueprint $table) {
            $table->integer('service_id')->references('id')->on('services');
            $table->integer('taxes_id')->references('id')->on('taxes');
            $table->primary(['taxes_id','service_id']);
        });

 Schema::create('location_locationtype', function (Blueprint $table) {
             $table->integer('location_id')->references('id')->on('locations');
            $table->integer('locationtype_id')->references('id')->on('locationtypes');
            $table->primary(['locationtype_id','location_id']);
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
        
        Schema::dropIfExists('service_taxes');
        Schema::dropIfExists('location_locationtype');
    }
}
