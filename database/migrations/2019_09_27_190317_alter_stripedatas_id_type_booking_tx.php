<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStripedatasIdTypeBookingTx extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_transactions', function (Blueprint $table) {
            $table->unsignedInteger('stripedatas_id')->change();
            $table->foreign('stripedatas_id')->references('id')->on('stripedatas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_transactions', function (Blueprint $table) {
            //
        });
    }
}
