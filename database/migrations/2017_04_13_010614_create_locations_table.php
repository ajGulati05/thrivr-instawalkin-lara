<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manager_id');
            $table->integer('locationtype_id');
            
            $table->text("name");
            $table->text("address");
            $table->text("phone");
            $table->text("postalcode");
            $table->text("lat")->nullable();
            $table->text("long")->nullable();
            $table->text("city");
            $table->text("province");
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
        Schema::dropIfExists('locations');
    }
}
