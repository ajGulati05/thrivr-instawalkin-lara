<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationtypesServicecategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locationtypes_servicecategories', function (Blueprint $table) {
            $table->integer('ltype_id')->references('id')->on('locationtypes');
            $table->integer('scategories_id')->references('id')->on('servicecategories');
            $table->primary(['ltype_id','scategories_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locationtypes_servicecategories');
    }
}
