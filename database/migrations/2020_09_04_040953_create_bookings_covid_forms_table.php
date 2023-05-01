<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsCovidFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_covid_forms', function (Blueprint $table) {
            $table->unsignedInteger('booking_id');
            $table->uuid('covidform_id');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('covidform_id')->references('id')->on('covid_forms');
            $table->primary(['booking_id','covidform_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_covid_forms');
    }
}
