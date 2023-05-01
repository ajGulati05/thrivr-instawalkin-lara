<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailabilityConstraintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('availability_constraints')) {
            Schema::create('availability_constraints', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('manager_id');
                $table->json('availability_constraints');
                $table->foreign('manager_id')->references('id')->on('managers');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availability_constraints');
    }
}
