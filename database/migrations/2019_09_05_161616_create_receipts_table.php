<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('receipts')) {

            Schema::create('receipts', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('booking_id');
                $table->foreign('booking_id')->references('id')->on('bookings');
                $table->dateTime('request_date');
                $table->string('requested_by');
                $table->unsignedInteger('requested_by_id');
                $table->timestamps();
                $table->boolean('duplicated');
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
        Schema::dropIfExists('receipts');
    }
}
