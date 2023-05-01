<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerSpecialities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers_specialities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('manager_id')->references('id')->on('managers');
            $table->unsignedInteger('manager_speciality_id')->references('id')->on('manager_specialities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers_specialities');
    }
}
