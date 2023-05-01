<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { Schema::table('bookings', function (Blueprint $table) {
               
                $table->unsignedBigInteger('userguest_id')->nullable();
                $table->unsignedInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('bookings');
                $table->foreign('userguest_id')->references('id')->on('user_guests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
