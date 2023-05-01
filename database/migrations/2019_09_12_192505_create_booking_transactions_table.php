<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //  capture_charge_id (will us the capture value when a capture is made), 
    //  stripe_code_status_charge  (stripe code value or something like that if it gets denied), 
    //  stripe_reason_charge (the reason for denial) 
    //  stripe_code_status_authorize  (stripe code value or something like that if it gets denied), 
    //  stripe_reason_authorize , stripe_id the card that was used in this transaction.

    public function up()
    {
        Schema::create('booking_transactions', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('booking_pricing_id')->nullable();
            $table->foreign('booking_pricing_id')->references('id')->on('booking_pricings');

            $table->string('charge_id')->nullable(); //(will use the charge id when a charge is created),
            $table->string('capture_charge_id')->nullable();
            $table->string('stripe_code_status_charge')->nullable();
            $table->string('stripe_reason_charge')->nullable();
            $table->string('stripe_code_status_authorize')->nullable();
            $table->string('stripe_reason_authorize')->nullable();
            $table->string('stripe_id')->nullable();
            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('booking_transactions');
    }
}
