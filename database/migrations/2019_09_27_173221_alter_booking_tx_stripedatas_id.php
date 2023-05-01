<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBookingTxStripedatasId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_transactions', function(Blueprint $table) {
            $table->renameColumn('stripe_id', 'stripedatas_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_transactions', function(Blueprint $table) {
            $table->renameColumn('stripedatas_id', 'stripe_id');
        });
    }
}
