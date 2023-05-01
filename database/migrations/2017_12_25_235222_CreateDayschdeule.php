<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayschdeule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('dayschedules', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('location_id')->references('id')->on('locations');
            $table->integer('service_id')->references('id')->on('services');
            $table->integer('employee_id')->references('id')->on('employees');
            $table->timestamp('scheduledtime')->nullable();
            $table->softDeletes();
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
       Schema::dropIfExists('dayschedules');
    }
}
