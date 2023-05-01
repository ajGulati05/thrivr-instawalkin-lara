<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('booking_pricings')) {

            Schema::create('booking_pricings', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('booking_id');
                $table->decimal('amount', 5, 2)->nullable();
                $table->decimal('tax_amount', 5, 2)->nullable();
                $table->timestamps();

                $table->decimal('tip_amount', 5, 2)->nullable();

                $table->foreign('booking_id')->references('id')->on('bookings');

                $table->decimal('credit_card_amount', 5, 2)->nullable();
                $table->decimal('discount_amount', 5, 2)->nullable();
                $table->decimal('cash_amount', 5, 2)->nullable();
                $table->decimal('direct_billing_amount', 5, 2)->nullable();

                $table->boolean('active')->default(false);
              
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
        Schema::dropIfExists('booking_pricings');


    }
}
