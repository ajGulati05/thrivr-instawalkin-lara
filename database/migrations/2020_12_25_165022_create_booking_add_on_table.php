<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAddOnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_add_ons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_id');
            $table->char('sub_modalities_code',4);
            $table->decimal('amount', 5, 2)->nullable();
            $table->decimal('tax_amount', 5, 2)->nullable();
            $table->boolean('active')->default(1);
            $table->foreign('booking_id')->references('id')->on('bookings');
             $table->foreign('sub_modalities_code')->references('code')->on('sub_modalities');
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
        Schema::dropIfExists('booking_add_ons');
    }
}
